<?php namespace Dooze\Galleries\Components;

use Cms\Classes\ComponentBase;
use Dooze\Galleries\Models\Gallery;

class GalleryComponent extends ComponentBase
{

	public $gallery;

	public function componentDetails()
	{
		return [
			'name' => 'Gallery',
			'description' => 'Gallery of images',
		];
	}

	public function defineProperties()
	{
		return [
			'result' => [
				'title' => 'Gallery title',
				'description' => 'Gallery to display',
			],
		];
	}

	public function onRun()
	{
		$this->gallery = $this->loadImages();
	}

	protected function loadImages()
	{
		$title = $this->property('result');

		return Gallery::where('title', $title)->first();
	}

}