<?php
/**
 * Class for getting notes, and chords from a given root
 * note.
 * @copyright (c) 2014, Jason Hittle
 * @author Jason Hittle
 */
class SongCheater {

    /**
     * Holds the twelve notes of the chromatic scale ('#' sign indicates a sharp)
     * @var array
     */
    public $chromatic_scale = array('A', 'A#', 'B', 'C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#');

    /**
     * The whole (w) and half (h) steps of the Major scale (Ionian mode) starting with
     * the root note. Example: C major would be C w D w E h F w G w A w B.
     * @var array
     */
    public $major_intervals = array('w', 'w', 'h', 'w', 'w', 'w');

    /**
     * The whole (w) and half (h) steps of the Minor scale (Aeolian mode) starting with
     * the root note. Example: A natural minor would be A w B h C w D w E h F w G.
     * @var array
     */
    public $minor_intervals = array('w', 'h', 'w', 'w', 'h', 'w');

    /**
     * Mapping of Major scale note positions to the major, minor, and diminished 
     * chords where the root note of the scale is "I"
     * @var array
     */
    public $major_prog = array(
        'major',
        'minor',
        'minor',
        'major',
        'major',
        'minor',
        'diminished'
    );

    /**
     * Mapping of Major scale note positions to the major, minor, and diminished 
     * chords where the root note of the scale is "I"
     * @var array
     */
    public $minor_prog = array(
        'minor',
        'diminished',
        'major',
        'minor',
        'minor',
        'major',
        'major'
    );

    /**
     * Holds the current root note
     * @var string
     */
    private $root_note;

    /**
     * Holds the current minor root note
     * @var string
     */
    private $minor_root_note;

    /**
     * An array containing the notes of the major scale.
     * @var array
     */
    public $major_scale;

    /**
     * An array containing the notes of the natural minor scale.
     * @var array
     */
    public $minor_scale;

    public function __construct($root_note = 'C') {
        $this->root_note = $this->isNote($root_note) ? $root_note : 'C';
        $this->setMajorScale();
        $this->minor_root_note = $this->findRelativeMinor();
        $this->setMinorScale();
    }

    private function orderChromaticScale($root_note) {
        $half_one = array_slice($this->chromatic_scale, array_search($root_note, $this->chromatic_scale));
        $half_two = array_diff($this->chromatic_scale, $half_one);
        return array_merge($half_one, $half_two);
    }

    public function makeScale($ordered_chromatic, $intervals) {
        $scale = array($ordered_chromatic[0]);
        $i = 0;
        foreach ($intervals as $mi) {
            $i = ($mi == 'w') ? $i + 2 : $i + 1;
            $scale[] = $ordered_chromatic[$i];
        }
        return $scale;
    }
    
    public function isNote($note)
    {
        $is_note = in_array($note, $this->chromatic_scale) ? TRUE : FALSE;
        return $is_note;
    }

    private function findRelativeMinor() {
        return $this->major_scale[5];
    }

    private function setMajorScale() {
        $this->major_scale = $this->makeScale($this->orderChromaticScale($this->root_note), $this->major_intervals);
    }

    private function setMinorScale() {
        $this->minor_scale = $this->makeScale($this->orderChromaticScale($this->minor_root_note), $this->minor_intervals);
    }

}
