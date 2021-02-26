<?php
namespace CarouselBrowse\Site\BlockLayout;

use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\View\Renderer\PhpRenderer;

use CarouselBrowse\Form\CarouselBlockForm;

class Carousel extends AbstractBlockLayout
{

	public function getLabel() {
		return 'Carousel browse'; // @translate
	}

	public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        $defaults = [
            'carouselHeading' => '',
			'autoSlide' => 'false',
            'autoSlideDuration' => 5000,
			'pauseOnHover' => 'true',
			'loop' => 'true',
            'draggable' => 'true',
            'fade' => 'false',
            'centerMode' => 'false',
            'dots' => 'true',
			'arrows' => 'true',
            'perPage' => 1,
            'perScroll' => 1,
			'slideCSSPadding' => '0 10px',
			'SlideCSSStretch' => 'false',
			'showCaption' => 'false',
			'floatCaption' => 'false',
			'slideCSSTextAlign' => 'center',
			'slideCSSTextColor' => '',
			'slideCSSTextSize' => '',
			'slideCSSBGColor' => '',
        ];

        $data = $block ? $block->data() + $defaults : $defaults;
        
        $carouselForm = new Form();
		$slideForm = new Form();
		$textForm = new Form();
		
		$carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][carouselHeading]',
			'type' => Element\Text::class,
			'options' => [
				'label' => 'Carousel title', // @translate
			]
		]);
		
		$carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][autoSlide]',
			'type' => Element\Checkbox::class,
            'options' => [
				'label' => 'Auto slide', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
			]
		]);

		$carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][autoSlideDuration]',
			'type' => Element\Text::class,
            'options' => [
				'label' => 'Auto slide duration', // @translate
				'info' => 'Time (in milliseconds) to pause before auto advance' // @translate
			]
		]);
		
		$carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][pauseOnHover]',
			'type' => Element\Checkbox::class,
			'options' => [
				'label' => 'Pause auto slide on hover', // @translate
				'checked_value' => 'true',
				'unchecked_value' => 'false',
			]
		]);
		
		$carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][loop]',
			'type' => Element\Checkbox::class,
            'options' => [
				'label' => 'Infinite loop', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
			]
		]);

		$carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][draggable]',
			'type' => Element\Checkbox::class,
            'options' => [
				'label' => 'Draggable', // @translate
                'info' => 'Drag/swipe to advance', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
			]
		]);
        
		// disable fade if more than one item per page since it doesn't display correctly
		if ($data['perPage'] > 1) {
			$disabledFade = true;
			$fade = 'false';
		} else {
			$disabledFade = false;
			$fade = $data['fade'];
		}
		
        $carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][fade]',
			'type' => Element\Checkbox::class,
            'options' => [
				'label' => 'Fade between slides', // @translate
                'info' => 'Note: only works with 1 item per page', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
			],
			'attributes' => [
				'disabled' => $disabledFade,
			]
		]);

        $carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][centerMode]',
			'type' => Element\Checkbox::class,
            'options' => [
				'label' => 'Center mode', // @translate
                'info' => 'Note: overrides items per scroll', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
			]
		]);
        
        $carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][dots]',
			'type' => Element\Checkbox::class,
            'options' => [
				'label' => 'Show navigation dots', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
			]
		]);
		
		$carouselForm->add([
			'name' => 'o:block[__blockIndex__][o:data][arrows]',
			'type' => Element\Checkbox::class,
            'options' => [
				'label' => 'Show navigation arrows', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
			]
		]);

		$slideForm->add([
			'name' => 'o:block[__blockIndex__][o:data][perPage]',
            'type' => Element\Number::class,
            'options' => [
				'label' => 'Items per page', // @translate
				'info' => 'The number of item slides shown per page.' // @translate
			],
			'attributes' => [
				'min' => 1,
                'max' => 10,
			]
		]);
        
        $slideForm->add([
			'name' => 'o:block[__blockIndex__][o:data][perScroll]',
            'type' => Element\Number::class,
            'options' => [
				'label' => 'Items per scroll', // @translate
				'info' => 'The number of item slides to advance.' // @translate
            ],
			'attributes' => [
				'min' => 1,
                'max' => 10,
			]
		]);
		
		$slideForm->add([
			'name' => 'o:block[__blockIndex__][o:data][slideCSSPadding]',
			'type' => Element\Text::class,
            'options' => [
				'label' => 'Slide Padding', // @translate
				'info' => 'Spacing/padding between slides in CSS syntax' // @translate
			]
		]);
		
		$slideForm->add([
			'name' => 'o:block[__blockIndex__][o:data][SlideCSSStretch]',
			'type' => Element\Checkbox::class,
			'options' => [
				'label' => 'Stretch image to fill slide', // @translate
				'checked_value' => 'true',
				'unchecked_value' => 'false',
			]
		]);
		
		$textForm->add([
			'name' => 'o:block[__blockIndex__][o:data][showCaption]',
			'type' => Element\Checkbox::class,
			'options' => [
				'label' => 'Show attachment caption', // @translate
				'checked_value' => 'true',
				'unchecked_value' => 'false',
			]
		]);
		
		$textForm->add([
			'name' => 'o:block[__blockIndex__][o:data][floatCaption]',
			'type' => Element\Checkbox::class,
			'options' => [
				'label' => 'Float title/caption', // @translate
				'info' => 'Superimpose title/caption over image.', // @translate
				'checked_value' => 'true',
				'unchecked_value' => 'false',
			]
		]);
		
		$textForm->add([
			'name' => 'o:block[__blockIndex__][o:data][slideCSSTextAlign]',
			'type' => Element\Select::class,
            'options' => [
				'label' => 'Text align', // @translate
				'value_options' => [
		            'left' => 'Left', // @translate
		            'center' => 'Center', // @translate
		            'right' => 'Right', // @translate
		        ],
			]
		]);
		
		$textForm->add([
			'name' => 'o:block[__blockIndex__][o:data][slideCSSTextColor]',
			'type' => Element\Text::class,
            'options' => [
				'label' => 'Text color/opacity', // @translate
				'info' => 'Use color name, hex value, or RGB/RGBA value' // @translate
			]
		]);
		
		$textForm->add([
			'name' => 'o:block[__blockIndex__][o:data][slideCSSTextSize]',
			'type' => Element\Text::class,
            'options' => [
				'label' => 'Text size', // @translate
				'info' => 'Use absolute, relative, percentage, length or global value' // @translate
			]
		]);
		
		$textForm->add([
			'name' => 'o:block[__blockIndex__][o:data][slideCSSBGColor]',
			'type' => Element\Text::class,
            'options' => [
				'label' => 'Text background color/opacity', // @translate
				'info' => 'Use color name, hex value, or RGB/RGBA value' // @translate
			]
		]);
		
		$writer = new \Laminas\Log\Writer\Stream('logs/application.log');
		$logger = new \Laminas\Log\Logger();
		$logger->addWriter($writer);

		$logger->info($fade);

		$carouselForm->setData([
			'o:block[__blockIndex__][o:data][carouselHeading]' => $data['carouselHeading'],
			'o:block[__blockIndex__][o:data][autoSlide]' => $data['autoSlide'],
			'o:block[__blockIndex__][o:data][autoSlideDuration]' => $data['autoSlideDuration'],
			'o:block[__blockIndex__][o:data][pauseOnHover]' => $data['pauseOnHover'],
			'o:block[__blockIndex__][o:data][loop]' => $data['loop'],
			'o:block[__blockIndex__][o:data][draggable]' => $data['draggable'],
			'o:block[__blockIndex__][o:data][fade]' => $fade,
            'o:block[__blockIndex__][o:data][centerMode]' => $data['centerMode'],
            'o:block[__blockIndex__][o:data][dots]' => $data['dots'],
			'o:block[__blockIndex__][o:data][arrows]' => $data['arrows'],
		]);
		$slideForm->setData([
			'o:block[__blockIndex__][o:data][perPage]' => $data['perPage'],
			'o:block[__blockIndex__][o:data][perScroll]' => $data['perScroll'],
			'o:block[__blockIndex__][o:data][slideCSSPadding]' => $data['slideCSSPadding'],
			'o:block[__blockIndex__][o:data][SlideCSSStretch]' => $data['SlideCSSStretch'],
		]);
		$textForm->setData([
			'o:block[__blockIndex__][o:data][showCaption]' => $data['showCaption'],
			'o:block[__blockIndex__][o:data][floatCaption]' => $data['floatCaption'],
			'o:block[__blockIndex__][o:data][slideCSSTextAlign]' => $data['slideCSSTextAlign'],
			'o:block[__blockIndex__][o:data][slideCSSTextColor]' => $data['slideCSSTextColor'],
			'o:block[__blockIndex__][o:data][slideCSSTextSize]' => $data['slideCSSTextSize'],
			'o:block[__blockIndex__][o:data][slideCSSBGColor]' => $data['slideCSSBGColor'],
		]);
		$carouselForm->prepare();
		$slideForm->prepare();
		$textForm->prepare();

		$html = '';
		$html .= $view->blockAttachmentsForm($block);
		$html .= '<a href="#" class="collapse" aria-label="collapse"><h4>' . $view->translate('Carousel Options'). '</h4></a>';
		$html .= '<div class="collapsible">';
		$html .= $view->formCollection($carouselForm);
		$html .= '</div>';
		$html .= '<a href="#" class="collapse" aria-label="collapse"><h4>' . $view->translate('Slide Options'). '</h4></a>';
		$html .= '<div class="collapsible">';
		$html .= $view->blockThumbnailTypeSelect($block);
		$html .= $view->formCollection($slideForm);
		$html .= '</div>';
		$html .= '<a href="#" class="collapse" aria-label="collapse"><h4>' . $view->translate('Text Options'). '</h4></a>';
		$html .= '<div class="collapsible">';
		$html .= $view->blockShowTitleSelect($block);
		$html .= $view->formCollection($textForm);
		$html .= '</div>';
		return $html;
    }

	public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
	{
		
        $attachments = $block->attachments();
        if (!$attachments) {
            return '';
        }

        $thumbnailType = $block->dataValue('thumbnail_type', 'large');
        $showTitleOption = $block->dataValue('show_title_option', 'item_title');
		
        return $view->partial('common/block-layout/carousel-browse', [
            'attachments' => $attachments,
			'carouselHeading' => $block->dataValue('carouselHeading'),
			'autoSlide' => $block->dataValue('autoSlide'),
            'autoSlideDuration' => $block->dataValue('autoSlideDuration'),
			'pauseOnHover' => $block->dataValue('pauseOnHover'),
			'loop' => $block->dataValue('loop'),
            'draggable' => $block->dataValue('draggable'),
            // 'fade' => $block->dataValue('fade'),
			'fade' => 'false',
            'centerMode' => $block->dataValue('centerMode'),
            'dots' => $block->dataValue('dots'),
			'arrows' => $block->dataValue('arrows'),
			'thumbnailType' => $thumbnailType,
			'perPage' => $block->dataValue('perPage'),
            'perScroll' => $block->dataValue('perScroll'),
			'slideCSSPadding' => $block->dataValue('slideCSSPadding'),
			'slideCSSStretch' => $block->dataValue('SlideCSSStretch'),
            'showTitleOption' => $showTitleOption,
			'showCaption' => $block->dataValue('showCaption'),
			'floatCaption' => $block->dataValue('floatCaption'),
			'slideCSSTextAlign' => $block->dataValue('slideCSSTextAlign'),
			'slideCSSTextColor' => $block->dataValue('slideCSSTextColor'),
			'slideCSSTextSize' => $block->dataValue('slideCSSTextSize'),
			'slideCSSBGColor' => $block->dataValue('slideCSSBGColor'),
		]);
	}
}
