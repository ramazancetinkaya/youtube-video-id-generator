<?php

/**
 * A class to generate YouTube video IDs.
 *
 * This class generates YouTube video IDs that can be used to create video links.
 * The generated IDs are cryptographically random and have the same format as the
 * video IDs used by YouTube.
 *
 * @package    YoutubeVideoIdGenerator
 * @author     Ramazan Çetinkaya
 * @license    MIT License
 * @version    1.0
 * @link       https://github.com/ramazancetinkaya/YoutubeVideoIdGenerator
 */
class YoutubeVideoIdGenerator {

    /**
     * The length of the YouTube video ID.
     */
    const VIDEO_ID_LENGTH = 11;

    /**
     * The characters that can be used in a YouTube video ID.
     */
    const VIDEO_ID_CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';

    /**
     * The default algorithm to use for ID generation.
     */
    const DEFAULT_ALGORITHM = 'sha256';

    /**
     * The algorithm to use for ID generation.
     *
     * @var string
     */
    private $algorithm;

    /**
     * The secret key to use for ID generation.
     *
     * @var string
     */
    private $secret_key;

    /**
     * Constructor.
     *
     * @param string $secret_key The secret key to use for ID generation.
     * @param string $algorithm  The algorithm to use for ID generation.
     */
    public function __construct($secret_key, $algorithm = self::DEFAULT_ALGORITHM) {
        $this->secret_key = $secret_key;
        $this->algorithm = $algorithm;
    }

    /**
     * Generate a YouTube video ID.
     *
     * @return string The generated YouTube video ID.
     */
    public function generateId() {
        $random_string = $this->generateRandomString();
        $hash = hash($this->algorithm, $random_string . $this->secret_key);
        $id = $this->convertHashToId($hash);
        return $id;
    }

    /**
     * Generate a random string of characters.
     *
     * @return string The generated random string.
     */
    private function generateRandomString() {
        $length = self::VIDEO_ID_LENGTH;
        $characters = self::VIDEO_ID_CHARACTERS;
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $random_string;
    }

    /**
     * Convert a hash to a YouTube video ID.
     *
     * @param string $hash The hash to convert.
     * @return string The generated YouTube video ID.
     */
    private function convertHashToId($hash) {
        $id = '';
        for ($i = 0; $i < self::VIDEO_ID_LENGTH; $i++) {
            $index = hexdec(substr($hash, $i * 2, 2)) % strlen(self::VIDEO_ID_CHARACTERS);
            $id .= substr(self::VIDEO_ID_CHARACTERS, $index, 1);
        }
        return $id;
    }

    /**
     * Get the YouTube video link for a given video ID.
     *
     * @param string $video_id The YouTube video ID.
     * @return string The YouTube video link.
     */
    public function getVideoLink($video_id) {
        return 'https://www.youtube.com/watch?v=' . $video_id;
    }
}
