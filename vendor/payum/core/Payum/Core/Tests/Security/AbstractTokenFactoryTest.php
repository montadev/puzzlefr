<?php
namespace Payum\Core\Tests\Security;

use Payum\Core\Model\Identity;
use Payum\Core\Model\Token;
use Payum\Core\Registry\StorageRegistryInterface;
use Payum\Core\Security\AbstractTokenFactory;
use Payum\Core\Security\TokenFactoryInterface;
use Payum\Core\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class AbstractTokenFactoryTest extends TestCase
{
    public function testShouldImplementsGenericTokenFactoryInterface()
    {
        $rc = new \ReflectionClass(AbstractTokenFactory::class);

        $this->assertTrue($rc->implementsInterface(TokenFactoryInterface::class));
    }

    public function testShouldBeAbstract()
    {
        $rc = new \ReflectionClass(AbstractTokenFactory::class);

        $this->assertFalse($rc->isInstantiable());
    }

    public function testShouldCreateTokenWithoutAfterPath()
    {
        $token = new Token();

        $tokenStorageMock = $this->createStorageMock();
        $tokenStorageMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($token)
        ;
        $tokenStorageMock
            ->expects($this->once())
            ->method('update')
            ->with($this->identicalTo($token))
        ;

        $model = new \stdClass();
        $identity = new Identity('anId', 'stdClass');
        $gatewayName = 'theGatewayName';

        $modelStorage = $this->createStorageMock();
        $modelStorage
            ->expects($this->once())
            ->method('identify')
            ->with($this->identicalTo($model))
            ->willReturn($identity)
        ;

        $storageRegistryMock = $this->createStorageRegistryMock();
        $storageRegistryMock
            ->expects($this->once())
            ->method('getStorage')
            ->with($this->identicalTo($model))
            ->willReturn($modelStorage)
        ;

        $factory = $this->createTokenFactoryMock($tokenStorageMock, $storageRegistryMock);

        $actualToken = $factory->createToken(
            $gatewayName,
            $model,
            'theTargetPath',
            array('target' => 'val')
        );

        $this->assertSame($token, $actualToken);
        $this->assertSame($gatewayName, $token->getGatewayName());
        $this->assertSame($identity, $token->getDetails());
        $this->assertSame(
            'theTargetPath?payum_token='.$token->getHash().'&target=val',
            $token->getTargetUrl()
        );
        $this->assertNull($token->getAfterUrl());
    }

    public function testShouldCreateTokenWithAfterUrl()
    {
        $token = new Token();

        $tokenStorageMock = $this->createStorageMock();
        $tokenStorageMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($token)
        ;
        $tokenStorageMock
            ->expects($this->once())
            ->method('update')
            ->with($this->identicalTo($token))
        ;

        $model = new \stdClass();
        $identity = new Identity('anId', 'stdClass');
        $gatewayName = 'theGatewayName';

        $modelStorage = $this->createStorageMock();
        $modelStorage
            ->expects($this->once())
            ->method('identify')
            ->with($this->identicalTo($model))
            ->willReturn($identity)
        ;

        $storageRegistryMock = $this->createStorageRegistryMock();
        $storageRegistryMock
            ->expects($this->once())
            ->method('getStorage')
            ->with($this->identicalTo($model))
            ->willReturn($modelStorage)
        ;

        $factory = $this->createTokenFactoryMock($tokenStorageMock, $storageRegistryMock);

        $actualToken = $factory->createToken(
            $gatewayName,
            $model,
            'theTargetPath',
            array('target' => 'val'),
            'theAfterPath',
            array('after' => 'val')
        );

        $this->assertSame($token, $actualToken);
        $this->assertSame($gatewayName, $token->getGatewayName());
        $this->assertSame($identity, $token->getDetails());
        $this->assertSame(
            'theTargetPath?payum_token='.$token->getHash().'&target=val',
            $token->getTargetUrl()
        );
        $this->assertSame('theAfterPath?after=val', $token->getAfterUrl());
    }

    public function testShouldCreateTokenWithIdentityAsModel()
    {
        $token = new Token();

        $tokenStorageMock = $this->createStorageMock();
        $tokenStorageMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($token)
        ;
        $tokenStorageMock
            ->expects($this->once())
            ->method('update')
            ->with($this->identicalTo($token))
        ;

        $gatewayName = 'theGatewayName';
        $identity = new Identity('anId', 'stdClass');

        $storageRegistryMock = $this->createStorageRegistryMock();
        $storageRegistryMock
            ->expects($this->never())
            ->method('getStorage')
        ;

        $factory = $this->createTokenFactoryMock($tokenStorageMock, $storageRegistryMock);

        $actualToken = $factory->createToken(
            $gatewayName,
            $identity,
            'theTargetPath',
            array('target' => 'val'),
            'theAfterPath',
            array('after' => 'val')
        );

        $this->assertSame($token, $actualToken);
        $this->assertSame($identity, $token->getDetails());
    }

    public function testShouldCreateTokenWithoutModel()
    {
        $token = new Token();

        $tokenStorageMock = $this->createStorageMock();
        $tokenStorageMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($token)
        ;
        $tokenStorageMock
            ->expects($this->once())
            ->method('update')
            ->with($this->identicalTo($token))
        ;

        $gatewayName = 'theGatewayName';

        $storageRegistryMock = $this->createStorageRegistryMock();
        $storageRegistryMock
            ->expects($this->never())
            ->method('getStorage')
        ;

        $factory = $this->createTokenFactoryMock($tokenStorageMock, $storageRegistryMock);

        $actualToken = $factory->createToken(
            $gatewayName,
            null,
            'theTargetPath',
            array('target' => 'val'),
            'theAfterPath',
            array('after' => 'val')
        );

        $this->assertSame($token, $actualToken);
        $this->assertNull($token->getDetails());
    }

    public function testShouldCreateTokenWithTargetPathAlreadyUrl()
    {
        $token = new Token();

        $tokenStorageMock = $this->createStorageMock();
        $tokenStorageMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($token)
        ;
        $tokenStorageMock
            ->expects($this->once())
            ->method('update')
            ->with($this->identicalTo($token))
        ;

        $model = new \stdClass();
        $identity = new Identity('anId', 'stdClass');
        $gatewayName = 'theGatewayName';

        $modelStorage = $this->createStorageMock();
        $modelStorage
            ->expects($this->once())
            ->method('identify')
            ->with($this->identicalTo($model))
            ->willReturn($identity)
        ;

        $storageRegistryMock = $this->createStorageRegistryMock();
        $storageRegistryMock
            ->expects($this->once())
            ->method('getStorage')
            ->with($this->identicalTo($model))
            ->willReturn($modelStorage)
        ;

        $factory = $this->createTokenFactoryMock($tokenStorageMock, $storageRegistryMock);

        $actualToken = $factory->createToken(
            $gatewayName,
            $model,
            'http://google.com/?foo=fooVal',
            array('target' => 'val'),
            'theAfterPath',
            array('after' => 'val')
        );

        $this->assertSame($token, $actualToken);
        $this->assertSame($gatewayName, $token->getGatewayName());
        $this->assertSame($identity, $token->getDetails());
        $this->assertSame(
            'http://google.com/?foo=fooVal&payum_token='.$token->getHash().'&target=val',
            $token->getTargetUrl()
        );
        $this->assertSame('theAfterPath?after=val', $token->getAfterUrl());
    }

    public function testShouldNotOverwritePayumTokenHashInAfterUrl()
    {
        $authorizeToken = new Token();

        $tokenStorageMock = $this->createStorageMock();
        $tokenStorageMock
            ->expects($this->at(0))
            ->method('create')
            ->willReturn($authorizeToken)
        ;
        $tokenStorageMock
            ->expects($this->at(1))
            ->method('update')
            ->with($this->identicalTo($authorizeToken))
        ;

        $model = new \stdClass();
        $identity = new Identity('anId', 'stdClass');
        $gatewayName = 'theGatewayName';

        $modelStorage = $this->createStorageMock();
        $modelStorage
            ->expects($this->once())
            ->method('identify')
            ->with($this->identicalTo($model))
            ->willReturn($identity)
        ;

        $storageRegistryMock = $this->createStorageRegistryMock();
        $storageRegistryMock
            ->expects($this->once())
            ->method('getStorage')
            ->with($this->identicalTo($model))
            ->willReturn($modelStorage)
        ;

        $factory = $this->createTokenFactoryMock($tokenStorageMock, $storageRegistryMock);

        $actualToken = $factory->createToken(
            $gatewayName,
            $model,
            'http://example.com/authorize.php',
            [],
            'http://google.com/?payum_token=foo',
            array('afterKey' => 'afterVal')
        );

        $this->assertSame($authorizeToken, $actualToken);
        $this->assertSame($gatewayName, $authorizeToken->getGatewayName());
        $this->assertSame($identity, $authorizeToken->getDetails());
        $this->assertSame(
            'http://example.com/authorize.php?payum_token='.$authorizeToken->getHash(),
            $authorizeToken->getTargetUrl()
        );
        $this->assertSame(
            'http://google.com/?payum_token=foo&afterKey=afterVal',
            $authorizeToken->getAfterUrl()
        );
    }

    public function testShouldAllowCreateAfterUrlWithoutPayumToken()
    {
        $authorizeToken = new Token();

        $tokenStorageMock = $this->createStorageMock();
        $tokenStorageMock
            ->expects($this->at(0))
            ->method('create')
            ->willReturn($authorizeToken)
        ;
        $tokenStorageMock
            ->expects($this->at(1))
            ->method('update')
            ->with($this->identicalTo($authorizeToken))
        ;

        $model = new \stdClass();
        $identity = new Identity('anId', 'stdClass');
        $gatewayName = 'theGatewayName';

        $modelStorage = $this->createStorageMock();
        $modelStorage
            ->expects($this->once())
            ->method('identify')
            ->with($this->identicalTo($model))
            ->willReturn($identity)
        ;

        $storageRegistryMock = $this->createStorageRegistryMock();
        $storageRegistryMock
            ->expects($this->once())
            ->method('getStorage')
            ->with($this->identicalTo($model))
            ->willReturn($modelStorage)
        ;

        $factory = $this->createTokenFactoryMock($tokenStorageMock, $storageRegistryMock);

        $actualToken = $factory->createToken(
            $gatewayName,
            $model,
            'http://example.com/authorize.php',
            [],
            'http://google.com/?payum_token=foo',
            array('payum_token' => null, 'afterKey' => 'afterVal')
        );

        $this->assertSame($authorizeToken, $actualToken);
        $this->assertSame($gatewayName, $authorizeToken->getGatewayName());
        $this->assertSame($identity, $authorizeToken->getDetails());
        $this->assertSame(
            'http://example.com/authorize.php?payum_token='.$authorizeToken->getHash(),
            $authorizeToken->getTargetUrl()
        );
        $this->assertSame(
            'http://google.com/?afterKey=afterVal',
            $authorizeToken->getAfterUrl()
        );
    }

    public function testShouldAllowCreateAfterUrlWithFragment()
    {
        $authorizeToken = new Token();

        $tokenStorageMock = $this->createStorageMock();
        $tokenStorageMock
            ->expects($this->at(0))
            ->method('create')
            ->willReturn($authorizeToken)
        ;
        $tokenStorageMock
            ->expects($this->at(1))
            ->method('update')
            ->with($this->identicalTo($authorizeToken))
        ;

        $model = new \stdClass();
        $identity = new Identity('anId', 'stdClass');
        $gatewayName = 'theGatewayName';

        $modelStorage = $this->createStorageMock();
        $modelStorage
            ->expects($this->once())
            ->method('identify')
            ->with($this->identicalTo($model))
            ->willReturn($identity)
        ;

        $storageRegistryMock = $this->createStorageRegistryMock();
        $storageRegistryMock
            ->expects($this->once())
            ->method('getStorage')
            ->with($this->identicalTo($model))
            ->willReturn($modelStorage)
        ;

        $factory = $this->createTokenFactoryMock($tokenStorageMock, $storageRegistryMock);

        $actualToken = $factory->createToken(
            $gatewayName,
            $model,
            'http://example.com/authorize.php',
            [],
            'http://google.com/foo/bar?foo=fooVal#fragment',
            array('payum_token' => null)
        );

        $this->assertSame($authorizeToken, $actualToken);
        $this->assertSame($gatewayName, $authorizeToken->getGatewayName());
        $this->assertSame($identity, $authorizeToken->getDetails());
        $this->assertSame(
            'http://example.com/authorize.php?payum_token='.$authorizeToken->getHash(),
            $authorizeToken->getTargetUrl()
        );
        $this->assertSame(
            'http://google.com/foo/bar?foo=fooVal#fragment',
            $authorizeToken->getAfterUrl()
        );
    }

    /**
     * @param StorageInterface $tokenStorage
     * @param StorageRegistryInterface $registry
     *
     * @return AbstractTokenFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createTokenFactoryMock(StorageInterface $tokenStorage, StorageRegistryInterface $registry)
    {
        $factoryMock = $this->getMockForAbstractClass(AbstractTokenFactory::class, array($tokenStorage, $registry));
        $factoryMock
            ->method('generateUrl')
            ->willReturnCallback(function ($path, array $args) {
                return $path.'?'.http_build_query($args);
            })
        ;

        return $factoryMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|StorageInterface
     */
    protected function createStorageMock()
    {
        return $this->createMock('Payum\Core\Storage\StorageInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|StorageRegistryInterface
     */
    protected function createStorageRegistryMock()
    {
        return $this->createMock('Payum\Core\Registry\StorageRegistryInterface');
    }
}
