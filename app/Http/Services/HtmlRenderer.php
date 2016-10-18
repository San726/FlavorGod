<?php

namespace Flavorgod\Http\services;

class HtmlRenderer
{

	/**
	 * The file path we will display when the asset has not been found
	 * @var string
	 */
	protected $imageAssetPath = '/images/noimage.png';

	/**
	 * The file path we will display when the asset has not been found
	 * @var string
	 */
	protected $assetNotFoundText = '';

	/**
	 * Return string from html document with selected tag
	 * @param string $tags
	 * @param array $variant
	 * @param string $relationType
	 * @param int $index
	 *
	 *
	 * @return string
	 */
	public function htmlText($tags, $variant, $relationType, $assetType, $index = 0)
	{
		$assetResponse = $this->assetExists($variant['assets'], $relationType, $assetType, $index);

		if($assetResponse != $this->assetNotFoundText){
			$filePath = $variant['assets'][$relationType][$index]['path'];
			if($tags){
				echo strip_tags(@file_get_contents($filePath), $tags);
			}else{
				echo strip_tags(@file_get_contents($filePath));
			}
		}else{
			echo $assetResponse;
		}
	}

	/**
	 * Return string from html assets assigned to the store
	 * @param string $tags
	 * @param filepath
	 */
	public function storeHtmlText($tags, $filePath)
	{
		if($tags){
			echo strip_tags(@file_get_contents($filePath), $tags);
		}else{
			echo strip_tags(@file_get_contents($filePath));
		}
	}

	/**
	 * Generate html syntax for the slider thumbnails
	 * @param array $variant
	 * @param array $asset_relation
	 * @param int $aset_index
	 */
	public function thumbnailSlider($variant, $relationType, $assetType, $index = 0)
	{
		$assetToDisplay = $variant['assets'][$relationType][$index];
		$assetPath = $this->assetExists($variant['assets'], $relationType, $assetType, $index);
		if($assetPath != $this->imageAssetPath){
			if($assetToDisplay['extension'] == 'mp4'){
				echo '<div class="item item-video"><div class="thumb-border"><a href=' . $assetToDisplay['path'] . '><img src='. $variant['assets']['thumbnail_video_image'][0]['path'].' alt="'.$variant['assets']['thumbnail_video_image'][0]['name'].'" title="'.$variant['assets']['thumbnail_video_image'][0]['name'].'" /></a></div></div>';
			}else{
				echo '<div class="item"><div class="thumb-border"><img src='. $assetToDisplay['path'] .' alt="'. $assetToDisplay['name'] .'" title="'. $assetToDisplay['name'] .'" /></div></div>';
			}
		}else{
			echo '<div class="item"><div class="thumb-border"><img src="'.$assetPath.'" alt="flavorgod" title="flavorgod" /></div></div>';
		}
	}

	public function numberToWords($number)
	{
		$words = [
			'first',
			'second',
			'third',
			'fourth',
			'fifth',
			'sixth',
			'seventh',
			'eight',
			'ninth',
			'tenth'
		];

		return @$words[$number];
	}

	/**
	 * Determine if asset exists and return the file path
	 * @param array $assets
	 * @param string $relationtype
	 * @param int $index
	 *
	 * @return string
	 */
	public function assetExists($assets, $relationType, $assetType, $index = 0)
	{
		if(count($assets) && array_key_exists($relationType, $assets)){
			if(array_key_exists($index, $assets[$relationType])){
				return $this->returnAsset($assetType, $assets[$relationType][$index]['path']);
			}
			return $this->returnAsset($assetType);
		}
			return $this->returnAsset($assetType);
	}

	/**
	 * Return the location path for the asset
	 * @param string $assetType
	 * @param string $assetPath
	 *
	 * @return string
	 */
	private function returnAsset($assetType, $assetPath = null)
	{
		if($assetPath){
			return $assetPath;
		}
		switch ($assetType) {
				case 'text':
					return $this->assetNotFoundText;
					break;
				default:
					return $this->imageAssetPath;
					break;
		}
	}

}