<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Game;
use Zend\Session\Container;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of Game
 *
 * @author ma2cdw
 */
class Game
{
    private $p_dictionary = array(
        'antidisestablishmentarianism',
        'bikes',
        'cheeseburgers',
        'crackerjack',
        'fusion',
        'mammalian'
    );
    private $p_session;
    public $m_word;
    public $m_tries;
    public $m_failedTries;
    
    
    public function __construct( $session )
    {
        $this->p_session = $session;
        if( $this->p_session->game_on && $this->p_session->word )
        {
            $this->m_word = $this->p_session->word;
            $this->m_tries = $this->p_session->tries;
            $this->m_failedTries = $this->p_session->failed_tries;
        }
        else
        {
            $this->m_failedTries = array();
            $this->m_tries = array();
            $this->m_word = new \Application\Game\Word( $this->p_dictionary[array_rand( $this->p_dictionary )] );
            $this->p_session->word = $this->m_word;
            $this->p_session->tries = $this->m_tries;
            $this->p_session->failed_tries = $this->m_failedTries;
        }
    }
    
    public function enterLetter( $letter )
    {
        $letter = ucfirst( $letter );
        if( in_array( $letter, $this->m_tries ) )
        {
            throw new \Exception( 'The letter ' . $letter . ' has already been tried!' -1 );
        }
        array_push( $this->m_tries, $letter );
        $this->p_session->tries = $this->m_tries;
        if( !$this->m_word->isLetterInWord( $letter ) )
        {
            array_push( $this->m_failedTries, $letter );
            sort( $this->m_failedTries );
            $this->p_session->failed_tries = $this->m_failedTries;
        }
        
        if( count( $this->m_failedTries ) === 6 )
        {
            throw new \Exception( 'You failed to guess the word!', 0 );
        }
        if( $this->m_word->m_completed )
        {
            throw new \Exception( 'You have guessed the word!', 1 );
        }
    }
    
    public function getWord()
    {
        $word = array();
        foreach( $this->m_word->m_letters as $idx => $letter )
        {
            $letter = each( $letter );
            if( $letter['value'] )
            {
                array_push( $word, $letter['key'] );
            }
            else
            {
                array_push( $word, NULL );
            }
        }
        return $word;
    }
    
    public function reset()
    {
        $this->p_session->game_on = false;
        $this->p_session->failed_tries = array();
        $this->p_session->tries = array();
        $this->p_session->word = null;
    }
}