<?php
/**
 * Gets all possible words for a given number sequence typed on a standard
 * telephone 10-digit keypad. Gets ALL letter combinations and not just
 * those which are actual words (which would require a dictionary lookup).
 *
 * Characters that do not correspond with a letter will be ignored.
 *
 * @param int|string $numberSequence The number sequence for which to find
 *                                   word possibilities. Invalid characters
 *                                   in the sequence will be skipped.
 *
 * @return array An array of unique lowercase string word possibilities
 *               given the number sequence.
 */
function getPossibleWords($numberSequence)
{    
    if (preg_match("/[A-Za-z0-9]+/", $numberSequence) === 0) return array();
    if (!in_array(gettype($numberSequence), array("integer", "string"))) return array();
    
    $keyPadGroup = array(
    	'0' => array(),
        '1' => array(),
        '2' => array('A', 'B', 'C'),
        '3' => array('D', 'E', 'F'),
        '4' => array('G', 'H', 'I'),
        '5' => array('J', 'K', 'L'),
        '6' => array('M', 'N', 'O'),
        '7' => array('P', 'Q', 'R', 'S'),
        '8' => array('T', 'U', 'V'),
        '9' => array('W', 'X', 'Y', 'Z'),
    );
    
    $seqInputToStr = gettype($numberSequence === 'integer') 
    	? (string) $numberSequence
    	: $numberSequence;
    $seqInputCombGrp = array();
    for ( $i=0; $i < strlen($seqInputToStr); $i++) {
    	$seqInputCombGrp[] = substr($seqInputToStr, $i, 1);
    }
    
    if (empty($seqInputCombGrp)) return array();
    
    $lettersGrp = array();
    foreach($seqInputCombGrp as $numberKey) {
    	if (!empty($keyPadGroup["{$numberKey}"])) {
        	$lettersGrp[] = $keyPadGroup["{$numberKey}"];
        }
    }
    
    $possibleWords = array();
    $iteration = count($seqInputCombGrp) * count($seqInputCombGrp);
    for ( $i=0; $i < $iteration; $i++) {
    	$letterStr = "";
        $keyItems = array();
        for ( $arCtr = 0; $arCtr < count($lettersGrp); $arCtr++) {
            $keyItems[] = rand(0, count($lettersGrp[$arCtr])-1);
        }
        $keyItemsStr = (implode("", $keyItems));
        $arCtr = 0;
        foreach($keyItems as $keyItem) {
        	$letterStr .= $lettersGrp[$arCtr][$keyItem];
        	$arCtr++;
        }
        $possibleWords[] = $letterStr;
    }

	$possibleWords = (!empty($possibleWords)) 
        ? array_map("strtolower", $possibleWords)
        : $possibleWords;
    
    return $possibleWords;
}
?>