(function($) {
	$(document).ready( function() {
		/* make some pro options disabled on the cntctfrmtdb_manager page */
		$( '.cntctfrmtdb .tablenav option[value="re_send_messages"]' ).css( 'display', 'block' ).attr( 'disabled', 'disabled' );
		$( '.cntctfrmtdb .tablenav option[value="download_attachments"]' ).css( 'display', 'block' ).attr( 'disabled', 'disabled' );

		/*
		* Hide blocks in options page
		*/
		$( '#cntctfrmtdb_save_messages_to_db' ).change( function() {
			if( $(this).is( ':checked' ) )
				$( '.cntctfrmtdb_options' ).css( 'display', 'block' );
			else
				$( '.cntctfrmtdb_options' ).css( 'display', 'none' );
		});
		
		$( '#cntctfrmtdb_delete_messages' ).change( function() {
			if ( $(this).is( ':checked' ) )
				$( '.cntctfrmtdb_delete_block' ).css( 'display', 'block' );
			else
				$( '.cntctfrmtdb_delete_block' ).css( 'display', 'none' );
		});
		/*
		* Function to change background color if message was not send 
		*/
		$( '.column-sent' ).each( function() {
			if ( $(this).children().hasClass( 'warning' ) ) {
				$(this).parent().addClass( 'not-sent-message' );
			}
		});
	
		/*
		* Function to slide content of message and show thumbnails 
		*/
		$( '#the-list tr' ).each( function() {
			var messageContainer = $( this ).children().children( '.message-container' );
			var fromInfo = $( this ).children().children( '.from-info' );
			var fromName = $( this ).children().children( '.from-name' );
			var height = messageContainer.height(); 
			messageContainer.height( 17 );
			fromInfo.css( 'display', 'none' ); // hide additional info in "from"-column
			var messageId = $( this ).children().children( 'input:checkbox' ).val();
			var nonceField = $( 'input#cntctfrmtdb_manager_nonce_name' ).val();
			// click on author's message name
			fromName.click( function() {
				if ( messageContainer .children().children().children().is( '.attachment-img' ) ) { // if attachment exists
					var attachmentImg = messageContainer .children().children().children( '.attachment-img' );
					height += 8 - messageContainer .children( '.attachments-preview' ).height() ;
					 // if attachment is image  and thumbnail is not loaded yet, we set request to get thumbnail and  original image by message id
					if( ! attachmentImg.children().is( '.cntctfrmtdb-thumbnail' ) ) {
						$.ajax({
							url: ajaxurl,
							type: "POST",
							data: { action: "cntctfrmtdb_show_attachment", cntctfrmtdb_ajax_message_id: messageId },
							beforeSend: function() {
								// set  a preloader image in the middle of current messagt row
								$( '.check-column input:checkbox' ).each( function() {
									if ( $( this ).val() == messageId ) {
										// display pfeloader in middle of current message
										var offsetRow = $(this).parent().parent().children( '.column-message' ).offset();
										var widthRow = $(this).parent().parent().children( '.column-message' ).width();
										var left = offsetRow.left + widthRow/2 - 16 - $( '#adminmenuwrap' ).width();
										var top = offsetRow.top - 24;
										$( '.cntctfrmtdb' ).prepend( '<div class="cntctfrmtdb-preloader" style="left: ' + left + 'px;top: ' + top + 'px"><img src="' + preloaderSrc + '"/></div>' );
										
									}
								});
							},
							success: function( result ) { 
								// we get data about thumbnail and original image from server and insert them in to column with message text
								$( '.check-column input:checkbox' ).each( function() {
									if ( $( this ).val() == messageId ) {
										$( '.cntctfrmtdb' ).children( '.cntctfrmtdb-preloader' ).remove(); //hide preloader 
										var anotherColumn = $( this ).parent().parent().children();
										var messageContainer = anotherColumn.children( '.message-container' );
										var thumbnail = messageContainer.children().children().children();
										// display attachments info
										if ( ! thumbnail.children().is( '.cntctfrmtdb-thumbnail' ) ) {
											thumbnail.append( result );
										}
										// Set the delay in 100 ms, so that the picture had time to load.
										// This is necessary to correctly counted by javascript new height of '.message-container' - block 
										// and slide down him in full height.  
										setTimeout( function() { 
											// slide content of message
											if ( messageContainer.height() == 17 ) {
												if ( thumbnail.children().is( '.cntctfrmtdb-thumbnail' ) )
													var newHeight = height + thumbnail.height();
												messageContainer.animate ( { // slide down '.message-container' block and show additional info in "from"-column
													height: newHeight
													}, 400, function() {
														anotherColumn.children('.from-info').fadeIn(200); 
												});
												// This is necessary that the height of the '.message-container' block is not incremented each time you click	
												var newHeight = height - thumbnail.height();
											} else { // slide up '.message-container' block and hide additional info in "from"-column
												anotherColumn.children( '.from-info' ).css( 'display','none' );
												messageContainer.animate ( {
													height: 17
													}, 400 );
											}
										}, 100);
										// if message was not read, so we change "not-read" status
										if ( anotherColumn.children().hasClass( 'not-read-message' ) ) {
											anotherColumn.children().removeClass( 'not-read-message' );
											cntctfrmtdb_change_read_status ( messageId, nonceField );
										}
									}
								});
							},
							error: function( request, status, error ) {
								alert( error + request.status );
							}
						}); //end of ajax request
					// if attachment is not image
					} else { //slide down message text 
						height = messageContainer.children( 'table' ).height() + messageContainer.children( 'div' ).height() + 8;// 8 is margin beetwen elements
						if( messageContainer.height() == 17 ) { // slide down '.message-container' block and show additional info in "from"-column
							messageContainer.animate ({
								height: height
								}, 400, function() {
									fromInfo.fadeIn( 200 );
							});
						} else { // slide up message text
							fromInfo.css( 'display', 'none' );
							messageContainer.animate ({ height: 17 }, 400 );
						}
					}
				} else { // if attachment have not image
					if( messageContainer.height() == 17 ) { //slide down message text
						if ( ! fromInfo.is( ':visible' ) ) { // this is necessary to correct work of slide up-down action if message has short text ( in 1 row )
							messageContainer.animate ({
								height: height
								}, 400, function() {
									fromInfo.fadeIn(200);
							});
						} else {
							fromInfo.css( 'display', 'none' );
						}
						// if message was not read, so we change "not-read" status
						if ( fromName.hasClass( 'not-read-message' ) ) {
							fromName.removeClass( 'not-read-message' );
							cntctfrmtdb_change_read_status ( messageId, nonceField );
						}
					} else {
						fromInfo.css( 'display', 'none' );  // slide up message text
						messageContainer.animate ( { height: 17 }, 400 );
					}
				}
				return false;
			});
		});

		/*
		* Function to change message status 
		*/
		var firstClick = 0;
		var lastClick = 0;
		var oldStatus =0;
		var nonceField = $( 'input#cntctfrmtdb_manager_nonce_name' ).val();
		$( '.column-status div' ).click( function() {
			if ( firstClick == 0 ) { // remember old status
				oldStatus = $(this).text();
				oldsStatus = parseInt( oldStatus );
				firstClick ++;
			}
			// change text of block during clicking
			var previousStatus = $(this).text(); 
			var messageID = $(this).parent().parent().parent().children( '.id' ).text();
			previousStatus = parseInt( previousStatus );
			var newStatus = previousStatus;
			if ( previousStatus <= 2 ) {
				newStatus++;
			} else { 
				previousStatus = 1;
				newStatus = 1;
			}
			$(this).text( newStatus );
			// change status icon  
			switch( newStatus ) {
				case 1:
					$(this).removeClass( 'cntctfrmtdb-trash' ).addClass( 'cntctfrmtdb-letter' );
					$(this).attr({ title: letter });
					break;
				case 2:
					$(this).removeClass( 'cntctfrmtdb-letter' ).addClass( 'cntctfrmtdb-spam' );
					$(this).attr({ title: spam });
					break;
				case 3:
					$(this).removeClass( 'cntctfrmtdb-spam' ).addClass( 'cntctfrmtdb-trash' );
					$(this).attr({ title: trash });
					break;
			}
			var messageId = $(this).parent().parent().children().children( 'input:checkbox' ).val();
			lastClick = new Date().getTime();
			setTimeout( 
				function() {
					var controlTime = new Date().getTime();
					var betweenTime = controlTime - lastClick;
					if ( betweenTime > 470  ) { // make ajax request if passed about 470 milliseconds after the last click
						if ( newStatus != oldStatus  ) {
							cntctfrmtdb_change_status( oldStatus, newStatus, messageID, nonceField );
							firstClick = 0;
						}						
					}
				}, 500
			);
			return false;
		});
		$( '#cntctfrmtdb_settings_form input' ).bind( "change click select", function() {
			if ( $( this ).attr( 'type' ) != 'submit' ) {
				$( '.updated.fade' ).css( 'display', 'none' );
				$( '#cntctfrmtdb_settings_notice' ).css( 'display', 'block' );
			};
		});
		$( ' #cntctfrmtdb_settings_form select').focus( function() {
			$( '.updated.fade' ).css( 'display', 'none' );
			$( '#cntctfrmtdb_settings_notice' ).css( 'display', 'block' );
		});
	});
})(jQuery);

/*
 * Function to change read/not-read status of message
*/

function cntctfrmtdb_change_read_status ( messageId, nonceField ) {
	( function($) {
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: { action: "cntctfrmtdb_read_message", cntctfrmtdb_ajax_nonce_field: nonceField, cntctfrmtdb_ajax_read_status: 1, cntctfrmtdb_ajax_message_id: messageId },
			succes: function() { // change number of messages in status links row
				$('.not-read-count').each( function() {
					var oldNumber = $(this).text();
					var newNumber = parseInt( oldNumber ) - 1;
					$(this).text( '' );
					$(this).text( newNumber );
				});
				$('.was-read-count').each( function() {
					var oldNumber = $(this).text();
					var newNumber = parseInt( oldNumber ) + 1;
					$(this).text( '' );
					$(this).text( newNumber );
				});
			},
			error: function( request, status, error ) {
				alert( error + request.status );
			}
		});
	}) (jQuery);
}


/*
 * Function to mark message as normal, spam or trash
*/

function cntctfrmtdb_change_status( oldStatus, newStatus, messageID, nonceField ) {
	(function($) {
		if ( oldStatus != newStatus ) {
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: { action: "cntctfrmtdb_change_staus", cntctfrmtdb_ajax_nonce_field: nonceField, cntctfrmtdb_ajax_message_status: newStatus, cntctfrmtdb_ajax_message_id: messageID, cntctfrmtdb_ajax_old_status: oldStatus },
				success: function( result ) {
					$( result ).insertAfter( '.cntctfrmtdb h2' );
					$( '.id' ).each( function() {
						if( $(this).text() == messageID ) {
							$(this).parent().fadeOut( 600 );
						}
					});
					// change numbers in action links row before and after list of messages
					var oldNumber = 0;
					var newNumber = 0;
					if ( oldStatus == 2 ) {
						$( '.spam-count' ).each( function() {
							oldNumber = $(this).text();
							newNumber = parseInt( oldNumber ) - 1;
							$(this).text('');
							$(this).text( newNumber );
						});
						
					} else {
						if ( oldStatus == 3 ) {
							$( '.trash-count' ).each( function() {
								var oldNumber = $(this).text();
								var newNumber = parseInt( oldNumber ) - 1;
								$(this).text('');
								$(this).text( newNumber );
							});
						}
					}
					if ( newStatus == 2) {
						$( '.spam-count' ).each( function() {
							oldNumber = $(this).text();
							newNumber = parseInt( oldNumber ) + 1;
							$(this).text('');
							$(this).text( newNumber );
						});
					} else {
						if ( newStatus == 3) {
							$( '.trash-count' ).each( function() {
								var oldNumber = $(this).text();
								var newNumber = parseInt( oldNumber ) + 1;
								$(this).text('');
								$(this).text( newNumber );
							});
						}
					}
				},
				error: function() {
					$('.cntctfrmtdb .cntctfrmtdb-notice').css( 'display', 'block' ).children( 'p' ).text( statusNotChanged );
				}
			});
		}
	}) (jQuery);
}

