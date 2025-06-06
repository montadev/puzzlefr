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

namespace Sylius\Behat\Element\Admin\Taxon;

use Behat\Mink\Exception\ElementNotFoundException;
use Sylius\Behat\Element\Admin\Crud\FormElement as BaseFormElement;

class ImageFormElement extends BaseFormElement implements ImageFormElementInterface
{
    public function attachImage(string $path, ?string $type = null): void
    {
        $this->getElement('add_image')->press();
        $this->waitForFormUpdate();

        $lastImage = $this->getElement('last_image');

        if (null !== $type) {
            $lastImage->fillField('Type', $type);
        }

        $filesPath = $this->getParameter('files_path');
        $lastImage->find('css', '[data-test-file]')->attachFile($filesPath . $path);
    }

    public function changeImageWithType(string $type, string $path): void
    {
        $image = $this->getElement('image_with_type', ['%type%' => $type]);

        $filesPath = $this->getParameter('files_path');
        $image->find('css', '[data-test-file]')->attachFile($filesPath . $path);
    }

    public function modifyFirstImageType(string $type): void
    {
        $this->getElement('first_image')->fillField('Type', $type);
    }

    public function removeImageWithType(string $type): void
    {
        $this->getElement('delete_image', ['%type%' => $type])->press();
        $this->waitForFormUpdate();
    }

    public function removeFirstImage(): void
    {
        $this->getElement('first_image')->find('css', '[data-test-delete-image]')->press();
        $this->waitForFormUpdate();
    }

    public function isImageWithTypeDisplayed(string $type): bool
    {
        try {
            $image = $this->getElement('image_with_type', ['%type%' => $type]);
        } catch (ElementNotFoundException) {
            return false;
        }

        $imageUrl = $image->getAttribute('data-test-image-url');
        $this->getDriver()->visit($imageUrl);
        $statusCode = $this->getDriver()->getStatusCode();
        $this->getDriver()->back();

        return in_array($statusCode, [200, 304], true);
    }

    public function countImages(): int
    {
        return count($this->getElement('images')->findAll('css', '[data-test-image]'));
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'add_image' => '[data-test-images] [data-test-add-image]',
            'delete_image' => '[data-test-images] [data-test-image][data-test-type="%type%"] [data-test-delete-image]',
            'first_image' => '[data-test-images] [data-test-image]:first-child',
            'image_with_type' => '[data-test-images] [data-test-image][data-test-type="%type%"]',
            'images' => '[data-test-images]',
            'last_image' => '[data-test-images] [data-test-image]:last-child',
        ]);
    }
}
