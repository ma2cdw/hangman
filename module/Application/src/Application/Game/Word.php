<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Game;

/**
 * Description of Word
 *
 * @author ma2cdw
 */
class Word {
    
    /**
     * Stores letters of word and whether or not they have been choosen
     * @var array 
     */
    public $m_letters;
    
    /**
     * flag for when word has been completed
     * @var bool 
     */
    public $m_completed;
    
    /**
     * Constructs letters array from param
     * @param string $word
     */
    public function __construct( $word )
    {
        $this->m_completed = false;
        $this->m_letters = array();
        foreach( str_split( $word ) as $letter )
        {
            array_push( $this->m_letters, array( ucfirst( $letter ) => false ) );
        }
    }
    
    /**
     * Checks if letter is in word updates all instances
     * returns true if found
     * @param string $letter
     * @return bool
     */
    public function isLetterInWord( $letter )
    {
        $letter = ucfirst( $letter );
        $letterExists = false;
        $completed = true;
        foreach( $this->m_letters as $idx => $letterInArray )
        {
            $letterFound = key_exists( $letter, $letterInArray );
            if( $letterFound )
            {
                $letterExists = true;
                $this->m_letters[$idx][$letter] = true;
            }
        }
        foreach( $this->m_letters as $idx => $letterInArray )
        {
            if( !reset( $this->m_letters[$idx] ) )
            {
                $completed = false;
                break;
            }
        }
        $this->m_completed = $completed;
        return $letterExists;
    }
}
