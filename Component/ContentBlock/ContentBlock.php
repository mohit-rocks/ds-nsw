<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Nsw\Component\ContentBlock;

use Pinto\Attribute\Asset;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Atom\Html\Html;
use PreviousNext\Ds\Common\Component as CommonComponent;
use PreviousNext\Ds\Nsw\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Asset\Css('content-block.css', preprocess: FALSE)]
#[Slots\Attribute\RenameSlot(original: 'containerAttributes', new: 'attributes')]
#[Scenarios([
  CommonComponent\ContentBlock\ContentBlockScenarios::class,
  ContentBlockScenarios::class,
])]
class ContentBlock extends CommonComponent\ContentBlock\ContentBlock implements Utility\NswObjectInterface {

  use Utility\ObjectTrait;

  protected function build(Slots\Build $build): Slots\Build {
    // @fixme workaround scoping bug with `_class_handler.twig`
    $this->containerAttributes['fixme'] = 'fixme';

    // Always remove link headings.
    if (NULL !== $this->linkList) {
      $this->linkList->title = NULL;
      $this->linkList->containerAttributes->addClass('nsw-content-block__list');
    }

    $this->title->containerAttributes->addClass('nsw-content-block__title');
    $this->title->level = Atom\Heading\HeadingLevel::Two;

    return $build
      ->set('title', $this->title)
      ->set('content', Html::createFromCollection($this))
      ->set('image', $this->image)
      ->set('icon', $this->icon)
      ->set('linkList', $this->linkList)
      ->set('link', $this->link)
      ->set('containerAttributes', $this->containerAttributes);
  }

}
