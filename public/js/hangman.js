$( document ).ready(
    function()
    {
        $( '.alphabet' ).click( function() {
            if( $( this ).hasClass( 'tried' ) )
            {
                alert( 'You have already tried this letter!' );
            }
            else
            {
                var letter = $(this);
                data = JSON.stringify( { "letter": letter.text() } );
                $.post( baseUrl + 'application/index/letter', data, function( result )
                {
                    var numFailedTries =  result.failed_tries.length + 1;
                    letter.addClass( 'tried' );
                    var src = $( '#hanging-man' ).attr( 'src' ).replace( /\d+/, numFailedTries );
                    $( '#hanging-man' ).attr( 'src', src );
                    if( result.failed_tries.indexOf( letter.text() ) > -1 )
                    {
                        letter.css( { 'color': 'red', 'border-bottom-color': 'red' } );
                    }
                    else
                    {
                        letter.css( { 'color': 'green', 'border-bottom-color': 'green' } );
                        $( '#word' ).empty();
                        $.each( result.word, function( idx, wordLetter ) {
                            wordLetter = wordLetter ? wordLetter : '';
                            $( '#word' ).append( $( '<div />',
                                                    { class: 'letter',
                                                      text: wordLetter,
                                                      css: { 'float':'left',
                                                               'padding': '2px',
                                                               'margin': '2px',
                                                               'min-width': '14px',
                                                               'height': '20px',
                                                               'border-bottom': '1px solid black'
                                                            } } ) );
                        } );                    
                    }
                    if( typeof result['game_finished'] !== 'undefined' )
                    {
                        if( confirm( result['game_finished'] ) )
                        {
                            window.location.reload(); 
                        }
                    }
                } );
            }
        } );
    }
);


