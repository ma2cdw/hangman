<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    public $m_game;
    private $p_session;
    
    public function __construct() {
        $this->p_session = new \Zend\Session\Container( 'hangman' );
        $this->m_game = new \Application\Game\Game( $this->p_session );
        if( !$this->p_session->game_on )
        {
            $this->m_game->reset();
            $this->m_game = new \Application\Game\Game( $this->p_session );
            $this->p_session->game_on = true;
        }
    }
    
    public function indexAction()
    {
        $data = array( 'word' => $this->m_game->getWord(),
                       'failed_tries' => $this->m_game->m_failedTries,
                       'tries' => $this->m_game->m_tries, );
        
        return new ViewModel( $data );
    }
    
    public function letterAction()
    {
        $params = \Zend\Json\Decoder::decode( trim( $this->getRequest()->getContent() ) );
        $data = array();
        try
        {
            $this->m_game->enterLetter( $params->letter );
        }
        catch( \Exception $e )
        {
            if( $e->getCode() === -1 )
            {
                $data['error'] = $e->getMessage();
            }
            else if( $e->getCode() >= 0 )
            {
                $this->p_session->game_on = false;
                $data['game_finished'] = $e->getMessage();
            }
        }
        
        $data['failed_tries'] = $this->m_game->m_failedTries;
        $data['tries'] = $this->m_game->m_tries;
        $data['word'] = $this->m_game->getWord();
        
        return new JsonModel( $data );
    }
}
