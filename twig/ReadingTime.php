<?php

namespace Grav\Common;

use Grav\Common\Grav;
use RocketTheme\Toolbox\ResourceLocator\UniformResourceLocator;

class ReadingTime extends \Twig_Extension
{
    private $grav;

    public function __construct()
    {
        $this->grav = Grav::instance();
    }

    public function getName()
    {
        return 'ReadingTime';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('reading_time', [$this, 'getReadingTextTime'])
        ];
    }

    public function getReadingTime(string $content) {
    	$wordCount = str_word_count(strip_tags($content));
        $wordsPerMin = $this->grav['config']->get('themes.acute.words_per_minute') ?: 250;

    	return intval($wordCount / $wordsPerMin);
    }

    public function getReadingTextTime(string $content) {
        var_dump($content); exit();
    	$minutes = $this->getReadingTime($content);

    	if ($minutes === 0) {
    		return 'Less than a minute';
    	} elseif ($minutes === 1) {
    		return 'Around a minute';
    	} else {
    	    return sprintf('%d min read', $minutes);
        }
    }
}
