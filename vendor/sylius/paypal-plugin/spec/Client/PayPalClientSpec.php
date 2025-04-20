<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Sylius\PayPalPlugin\Client;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\PayPalPlugin\Client\PayPalClientInterface;
use Sylius\PayPalPlugin\Exception\PayPalApiTimeoutException;
use Sylius\PayPalPlugin\Exception\PayPalAuthorizationException;
use Sylius\PayPalPlugin\Provider\PayPalConfigurationProviderInterface;
use Sylius\PayPalPlugin\Provider\UuidProviderInterface;

final class PayPalClientSpec extends ObjectBehavior
{
    function let(
        ClientInterface $client,
        LoggerInterface $logger,
        UuidProviderInterface $uuidProvider,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        RequestInterface $request,
        StreamInterface $stream,
    ): void {
        $channelContext->getChannel()->willReturn($channel);
        $streamFactory->createStream(Argument::any())->willReturn($stream);
        $request->withHeader(Argument::any(), Argument::any())->willReturn($request);
        $request->withBody(Argument::any())->willReturn($request);

        $this->beConstructedWith(
            $client,
            $logger,
            $uuidProvider,
            $payPalConfigurationProvider,
            $channelContext,
            'https://test-api.paypal.com/',
            5,
            $requestFactory,
            $streamFactory,
            false,
        );
    }

    function it_implements_paypal_client_interface(): void
    {
        $this->shouldImplement(PayPalClientInterface::class);
    }

    function it_returns_auth_token_for_given_client_data(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $body,
    ): void {
        $requestFactory->createRequest('POST', 'https://test-api.paypal.com/v1/oauth2/token')->willReturn($request);
        $request->withHeader(Argument::any(), Argument::any())->willReturn($request);
        $request->withBody(Argument::any())->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn('{"access_token": "TOKEN"}');

        $this->authorize('CLIENT_ID', 'CLIENT_SECRET')->shouldReturn(['access_token' => 'TOKEN']);
    }

    function it_throws_an_exception_if_client_could_not_be_authorized(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        ResponseInterface $response,
    ): void {
        $requestFactory->createRequest('POST', 'https://test-api.paypal.com/v1/oauth2/token')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);

        $response->getStatusCode()->willReturn(401);

        $this
            ->shouldThrow(PayPalAuthorizationException::class)
            ->during('authorize', ['CLIENT_ID', 'CLIENT_SECRET'])
        ;
    }

    function it_calls_get_request_on_paypal_api(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelInterface $channel,
        ResponseInterface $response,
        StreamInterface $body,
    ): void {
        $payPalConfigurationProvider->getPartnerAttributionId($channel)->willReturn('TRACKING-ID');

        $requestFactory->createRequest('GET', 'https://test-api.paypal.com/v2/get-request/')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);

        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn('{"status": "OK", "id": "123123"}');

        $this->get('v2/get-request/', 'TOKEN')->shouldReturn(['status' => 'OK', 'id' => '123123']);
    }

    function it_logs_all_requests_if_logging_level_is_increased(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        RequestInterface $request,
        LoggerInterface $logger,
        UuidProviderInterface $uuidProvider,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelContextInterface $channelContext,
        ChannelInterface $channel,
        ResponseInterface $response,
        StreamInterface $body,
    ): void {
        $this->beConstructedWith(
            $client,
            $logger,
            $uuidProvider,
            $payPalConfigurationProvider,
            $channelContext,
            'https://test-api.paypal.com/',
            5,
            $requestFactory,
            $streamFactory,
            true,
        );

        $channelContext->getChannel()->willReturn($channel);
        $payPalConfigurationProvider->getPartnerAttributionId($channel)->willReturn('TRACKING-ID');

        $requestFactory->createRequest('GET', 'https://test-api.paypal.com/v2/get-request/')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);

        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn('{"status": "OK", "id": "123123"}');

        $logger
            ->debug('GET request to "https://test-api.paypal.com/v2/get-request/" called successfully')
            ->shouldBeCalled()
        ;

        $this->get('v2/get-request/', 'TOKEN')->shouldReturn(['status' => 'OK', 'id' => '123123']);
    }

    function it_logs_debug_id_from_failed_get_request(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        LoggerInterface $logger,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelInterface $channel,
        RequestException $exception,
        ResponseInterface $response,
        StreamInterface $body,
    ): void {
        $payPalConfigurationProvider->getPartnerAttributionId($channel)->willReturn('TRACKING-ID');

        $requestFactory->createRequest('GET', 'https://test-api.paypal.com/v2/get-request/')->willReturn($request);
        $client->sendRequest($request)->willThrow($exception->getWrappedObject());

        $exception->getResponse()->willReturn($response);
        $response->getBody()->willReturn($body);
        $response->getStatusCode()->willReturn(400);
        $body->getContents()->willReturn('{"status": "FAILED", "debug_id": "123123"}');

        $logger
            ->error('GET request to "https://test-api.paypal.com/v2/get-request/" failed with debug ID 123123')
            ->shouldBeCalled()
        ;

        $this->get('v2/get-request/', 'TOKEN')->shouldReturn(['status' => 'FAILED', 'debug_id' => '123123']);
    }

    function it_calls_post_request_on_paypal_api(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $body,
        UuidProviderInterface $uuidProvider,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelInterface $channel,
    ): void {
        $uuidProvider->provide()->willReturn('REQUEST-ID');
        $payPalConfigurationProvider->getPartnerAttributionId($channel)->willReturn('TRACKING-ID');

        $requestFactory->createRequest('POST', 'https://test-api.paypal.com/v2/post-request/')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);

        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn('{"status": "OK", "id": "123123"}');

        $this
            ->post('v2/post-request/', 'TOKEN', ['parameter' => 'value', 'another_parameter' => 'another_value'])
            ->shouldReturn(['status' => 'OK', 'id' => '123123'])
        ;
    }

    function it_calls_post_request_on_paypal_api_with_extra_headers(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        ResponseInterface $response,
        StreamFactoryInterface $streamFactory,
        StreamInterface $body,
        UuidProviderInterface $uuidProvider,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelInterface $channel,
    ): void {
        $uuidProvider->provide()->willReturn('REQUEST-ID');
        $payPalConfigurationProvider->getPartnerAttributionId($channel)->willReturn('TRACKING-ID');

        $requestFactory->createRequest('POST', 'https://test-api.paypal.com/v2/post-request/')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);

        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn('{"status": "OK", "id": "123123"}');

        $this
            ->post('v2/post-request/', 'TOKEN', ['parameter' => 'value', 'another_parameter' => 'another_value'], ['CUSTOM_HEADER' => 'header'])
            ->shouldReturn(['status' => 'OK', 'id' => '123123'])
        ;

        $request->withHeader('CUSTOM_HEADER', 'header')->shouldBeCalled();
        $streamFactory->createStream(json_encode(['parameter' => 'value', 'another_parameter' => 'another_value']))->shouldBeCalled();
    }

    function it_logs_debug_id_from_failed_post_request(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        LoggerInterface $logger,
        RequestException $exception,
        ResponseInterface $response,
        StreamInterface $body,
        UuidProviderInterface $uuidProvider,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelInterface $channel,
    ): void {
        $uuidProvider->provide()->willReturn('REQUEST-ID');
        $payPalConfigurationProvider->getPartnerAttributionId($channel)->willReturn('TRACKING-ID');

        $requestFactory->createRequest('POST', 'https://test-api.paypal.com/v2/post-request/')->willReturn($request);
        $client->sendRequest($request)->willThrow($exception->getWrappedObject());

        $exception->getResponse()->willReturn($response);
        $response->getBody()->willReturn($body);
        $response->getStatusCode()->willReturn(400);
        $body->getContents()->willReturn('{"status": "FAILED", "debug_id": "123123"}');

        $logger
            ->error('POST request to "https://test-api.paypal.com/v2/post-request/" failed with debug ID 123123')
            ->shouldBeCalled()
        ;

        $this
            ->post('v2/post-request/', 'TOKEN', ['parameter' => 'value', 'another_parameter' => 'another_value'])
            ->shouldReturn(['status' => 'FAILED', 'debug_id' => '123123'])
        ;
    }

    function it_calls_patch_request_on_paypal_api(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        ResponseInterface $response,
        StreamInterface $body,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelInterface $channel,
    ): void {
        $payPalConfigurationProvider->getPartnerAttributionId($channel)->willReturn('TRACKING-ID');
        $requestFactory->createRequest('PATCH', 'https://test-api.paypal.com/v2/patch-request/123123')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($body);
        $body->getContents()->willReturn('{"status": "OK", "id": "123123"}');

        $this
            ->patch('v2/patch-request/123123', 'TOKEN', ['parameter' => 'value', 'another_parameter' => 'another_value'])
            ->shouldReturn(['status' => 'OK', 'id' => '123123'])
        ;
    }

    function it_logs_debug_id_from_failed_patch_request(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        LoggerInterface $logger,
        RequestException $exception,
        ResponseInterface $response,
        StreamInterface $body,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelInterface $channel,
    ): void {
        $payPalConfigurationProvider->getPartnerAttributionId($channel)->willReturn('TRACKING-ID');

        $requestFactory->createRequest('PATCH', 'https://test-api.paypal.com/v2/patch-request/123123')->willReturn($request);
        $client->sendRequest($request)->willThrow($exception->getWrappedObject());

        $exception->getResponse()->willReturn($response);
        $response->getBody()->willReturn($body);
        $response->getStatusCode()->willReturn(400);
        $body->getContents()->willReturn('{"status": "FAILED", "debug_id": "123123"}');

        $logger
            ->error('PATCH request to "https://test-api.paypal.com/v2/patch-request/123123" failed with debug ID 123123')
            ->shouldBeCalled()
        ;

        $this
            ->patch('v2/patch-request/123123', 'TOKEN', ['parameter' => 'value', 'another_parameter' => 'another_value'])
            ->shouldReturn(['status' => 'FAILED', 'debug_id' => '123123'])
        ;
    }

    function it_throws_exception_if_the_timeout_has_been_reached_the_specified_amount_of_time(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        RequestInterface $request,
        PayPalConfigurationProviderInterface $payPalConfigurationProvider,
        ChannelInterface $channel,
    ): void {
        $payPalConfigurationProvider->getPartnerAttributionId($channel)->willReturn('TRACKING-ID');

        $requestFactory->createRequest('GET', 'https://test-api.paypal.com/v2/get-request/')->willReturn($request);
        $client->sendRequest($request)->willThrow(ConnectException::class);

        $this
            ->shouldThrow(PayPalApiTimeoutException::class)
            ->during('get', ['v2/get-request/', 'TOKEN'])
        ;
    }
}
