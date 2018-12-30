<?php

namespace Grav\Theme;

use Grav\Common\Theme;
use RocketTheme\Toolbox\Event\Event;

class Acute extends Theme
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPageContentRaw' => ['onPageContentRaw', 0]
        ];
    }

    public function onPageContentRaw(Event $event)
    {
        $page = $event['page'];
        $page->modifyHeader('reading_time', $this->getReadingTextTime($page->content()));
    }

    public function getReadingTime(string $content) {
    	$wordCount = str_word_count(strip_tags($content));
        $wordsPerMin = $this->config->get('themes.acute.words_per_minute') ?: 250;

    	return intval($wordCount / $wordsPerMin);
    }

    public function getReadingTextTime(string $content) {
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
