//************************************************/
/* IPB3 Javascript								*/
/* -------------------------------------------- */
/* ipb.js - Global code							*/
/* (c) IPS, Inc 2008							*/
/* -------------------------------------------- */
/* Author: Rikki Tissier						*/
/************************************************/

window.IPBoard = Class.create({
	namePops: [],
	vars: [],
	lang: [],
	templates: [],
	editors: $A(),
	
	initialize: function()
	{
		Debug.write("IPBjs is loading...");
		
		document.observe("dom:loaded", function(){
			this.Cookie.init();
			
			// Show a little loading graphic
			Ajax.Responders.register({
			  onLoading: function() {
			    if( !$('ajax_loading') )
				{
					if( !ipb.templates['ajax_loading'] ){ return; }
					$('ipboard_body').insert( ipb.templates['ajax_loading'] );
				}
				
				var effect = new Effect.Appear( $('ajax_loading'), { duration: 0.2 } );
			  },
			  onComplete: function() {
				if( !$('ajax_loading') ){ return; }
			    var effect = new Effect.Fade( $('ajax_loading'), { duration: 0.2 } );
			  }
			});
			
		}.bind(this));
	},
	positionCenter: function( elem, dir )
	{
		if( !$(elem) ){ return; }
		elem_s = $(elem).getDimensions();
		window_s = document.viewport.getDimensions();
		window_offsets = document.viewport.getScrollOffsets();

		center = { 	left: ((window_s['width'] - elem_s['width']) / 2),
					 top: ((window_s['height'] - elem_s['height']) / 2)
				}
		
		if( typeof(dir) == 'undefined' || ( dir != 'h' && dir != 'v' ) )
		{
			$(elem).setStyle('top: ' + center['top'] + 'px; left: ' + center['left'] + 'px');
		}
		else if( dir == 'h' )
		{
			$(elem).setStyle('left: ' + center['left'] + 'px');
		}
		else if( dir == 'v' )
		{
			$(elem).setStyle('top: ' + center['top'] + 'px');
		}
		
		$(elem).setStyle('position: fixed');
	},
	showModal: function()
	{
		if( !$('ipb_modal') )
		{
			this.createModal();
		}
		this.modal.show();
	},
	hideModal: function()
	{
		if( !$('ipb_modal') ){ return; }
		this.modal.hide();		
	},
	createModal: function()
	{
		this.modal = new Element('div', { id: 'ipb_modal', 'class': 'modal' } ).hide();
		this.modal.setStyle("width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; overflow: hidden; z-index: 1000; opacity: 0.2");
		$('ipboard_body').insert({bottom: this.modal});
	},
	alert: function( message )
	{
		if( !$('ipb_alert') )
		{
			this.createAlert();
		}
		
		this.showModal();
		
		$('ipb_alert_message').update( message );
	},
	createAlert: function()
	{
		wrapper = new Element('div', { id: 'ipb_alert' } );
		icon = new Element('div', { id: 'ipb_alert_icon' } );
		message = new Element('div', { id: 'ipb_alert_message' } );
		ok_button = new Element('input', { 'type': 'button', 'value': "OK", id: 'ipb_alert_ok' });
		cancel_button = new Element('input', { 'type': 'button', 'value': "Cancel", id: 'ipb_alert_cancel' });
		
		wrapper.insert( {bottom: icon} ).insert( {bottom: message} ).insert( {bottom: ok_button} ).insert( {bottom: cancel_button} ).setStyle('z-index: 1001');
		
		$('ipboard_body').insert({bottom: wrapper});
		
		this.positionCenter( wrapper, 'h' );
	},
	editorInsert: function( content, editorid )
	{
		// If no editor id supplied, lets use the first one
		if( !editorid )	{
			Debug.dir( ipb.editors );
			var editor = $A( ipb.editors ).first();
			
			Debug.write( editor );
		} else {
			var editor = ipb.editors[ editorid ];
		}
		
		if( Object.isUndefined( editor ) )
		{
			Debug.error( "Can't find any suitable editor" );
			return;
		}
		
		editor.insert_text( content );
	}
});

/* ===================================================================================================== */
/* IPB3 Cookies */

/* Meow */
IPBoard.prototype.Cookie = {
	store: [],
	set: function( name, value, sticky )
	{
		var expires = '';
		var path = '/';
		var domain = '';
		
		if( !name )
		{
			return;
		}
		
		if( sticky )
		{	
			if( sticky == 1 )
			{
				expires = "; expires=Wed, 1 Jan 2020 00:00:00 GMT";
			}
			else if( sticky == -1 ) // Delete
			{
				expires = "; expires=Thu, 01-Jan-1970 00:00:01 GMT";
			}
			else if( sticky.length > 10 )
			{
				expires = "; expires=" + sticky;
			}
		}
		if( ipb.vars['cookie_domain'] )
		{
			domain = "; domain=" + ipb.vars['cookie_domain'];
		}
		if( ipb.vars['cookie_path'] )
		{
			path = ipb.vars['cookie_path'];
		}
		
		document.cookie = ipb.vars['cookie_id'] + name + "=" + escape( value ) + "; path=" + path + expires + domain + ';';
		
		ipb.Cookie.store[ name ] = value;
		
		Debug.info( "Set cookie: " + ipb.vars['cookie_id'] + name + "=" + value + "; path=" + path + expires + domain + ';' );
	},
	get: function( name )
	{
		if( ipb.Cookie.store[ name ] )
		{
			return ipb.Cookie.store[ name ];
		}
		
		return '';
	},
	doDelete: function( name )
	{
		Debug.info("Deleting cookie " + name);
		ipb.Cookie.set( name, '', -1 );
	},
	init: function()
	{
		// Init cookies by pulling in document.cookie
		skip = ['session_id', 'ipb_admin_session_id', 'member_id', 'pass_hash'];
		cookies = $H( document.cookie.replace(" ", '').toQueryParams(";") );
		
		if( cookies )
		{
			cookies.each( function(cookie){
				cookie[0] = cookie[0].strip();
				
				if( ipb.vars['cookie_id'] != '' )
				{
					if( !cookie[0].startsWith( ipb.vars['cookie_id'] ) )
					{
						return;
					}
					else
					{
						cookie[0] = cookie[0].replace( ipb.vars['cookie_id'], '' );
					}
				}
				
				if( skip[ cookie[0] ] )
				{
					return;
				}
				else
				{
					ipb.Cookie.store[ cookie[0] ] = unescape( cookie[1] || '' );
				}				
			});
		}
			
	}
};

/* ===================================================================================================== */
/* Form validation */

IPBoard.prototype.validate = {
	// Checks theres actually a value
	isFilled: function( elem )
	{
		if( !$( elem ) ){ return null; }
		return !$F(elem).blank();
	},
	isNumeric: function( elem )
	{
		if( !$( elem ) ){ return null; }
		return $F(elem).match( /^[\d]+?$/ );
	},
	isMatching: function( elem1, elem2 )
	{
		if( !$( elem1 ) || !$( elem2 ) ){ return null; }
		return $F(elem1) == $F(elem2);
	},
	email: function( elem )
	{
		if( !$( elem ) ){ return null; }
		if( $F( elem ).match( /^.+@.+\..{2,3}$/ ) ){
			return true;
		} else {
			return false;
		}
	}
	/*isURL: function( elem )
	{
		if( !$(elem) ){ return null; }		
		return ( $F(elem).match( /^[A-Za-z]+:\/\/[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$/ ) == null ) ? true : false;
	}*/
};

/* ===================================================================================================== */
/* AUTOCOMPLETE */

IPBoard.prototype.Autocomplete = Class.create( {
	
	initialize: function(id, options)
	{
		this.id = $( id ).id;
		this.timer = null;
		this.last_string = '';
		this.internal_cache = $H();
		this.pointer = 0;
		this.items = $A();
		this.observing = true;
		this.options = Object.extend({
			min_chars: 3,
			multibox: false,
			global_cache: false,
			classname: 'ipb_autocomplete',
			templates: 	{ 
							wrap: new Template("<ul id='#{id}'></ul>"),
							item: new Template("<li id='#{id}'>#{itemvalue}</li>")
						}
		}, arguments[1] || {});
		
		//-----------------------------------------
		
		if( !$( this.id ) ){
			Debug.error("Invalid textbox ID");
			return false;
		}
		
		this.obj = $( this.id );
		
		if( !this.options.url )
		{
			Debug.error("No URL specified for autocomplete");
			return false;
		}
		
		$( this.obj ).writeAttribute('autocomplete', 'off');
		
		this.buildList();
		
		// Observe keypress
		$( this.obj ).observe('focus', this.timerEventFocus.bindAsEventListener( this ) );
		$( this.obj ).observe('blur', this.timerEventBlur.bindAsEventListener( this ) );
		$( this.obj ).observe('keypress', this.eventKeypress.bindAsEventListener( this ) );
		
	},
	
	eventKeypress: function(e)
	{
		if( ![ Event.KEY_TAB, Event.KEY_UP, Event.KEY_DOWN, Event.KEY_LEFT, Event.KEY_RIGHT, Event.KEY_RETURN ].include( e.keyCode ) ){
			return; // Not interested in anything else
		}
		
		if( $( this.list ).visible() )
		{
			switch( e.keyCode )
			{
				case Event.KEY_TAB:
				case Event.KEY_RETURN:
					this.selectCurrentItem(e);
				break;
				case Event.KEY_UP:
				case Event.KEY_LEFT:
					this.selectPreviousItem(e);
				break;
				case Event.KEY_DOWN:
				case Event.KEY_RIGHT:
					this.selectNextItem(e);
				break;
			}
			
			Event.stop(e);
		}	
	},
	
	// MOUSE & KEYBOARD EVENT
	selectCurrentItem: function(e)
	{
		var current = $( this.list ).down('.active');
		this.unselectAll();
		
		if( !Object.isUndefined( current ) )
		{
			var itemid = $( current ).id.replace( this.id + '_ac_item_', '');
			if( !itemid ){ return; }
			
			// Get value
			var value = this.items[ itemid ];
			
			if( this.options.multibox )
			{
				// some logic to get current name
				if( $F( this.obj ).indexOf(',') !== -1 )
				{
					var pieces = $F( this.obj ).split(',');
					pieces[ pieces.length - 1 ] = '';

					$( this.obj ).value = pieces.join(',') + ' ';
				}
				else
				{
					$( this.obj ).value = '';
				}
				
				$( this.obj ).value = $F( this.obj ) + value + ', ';
			}
			else
			{
				$( this.obj ).value = value;
				var effect = new Effect.Fade( $(this.list), { duration: 0.3 } );
				this.observing = false;
			}			
		}
		
		$( this.obj ).focus();
	},
	
	// MOUSE EVENT
	selectThisItem: function(e)
	{
		this.unselectAll();
		
		var items = $( this.list ).immediateDescendants();
		var elem = Event.element(e);
		
		// Find the element
		while( !items.include( elem ) )
		{
			elem = elem.up();
		}
		
		$( elem ).addClassName('active');
	},
	
	// KEYBOARD EVENT
	selectPreviousItem: function(e)
	{
		var current = $( this.list ).down('.active');
		this.unselectAll();
		
		if( Object.isUndefined( current ) )
		{
			this.selectFirstItem();
		}
		else
		{
			var prev = $( current ).previous();
			
			if( prev ){
				$( prev ).addClassName('active');
			}
			else
			{
				this.selectLastItem();
			}
		}
	},
	
	// KEYBOARD EVENT
	selectNextItem: function(e)
	{
		// Get the current item
		var current = $( this.list ).down('.active');
		this.unselectAll();
		
		if( Object.isUndefined( current ) ){
			this.selectFirstItem();
		}
		else
		{
			var next = $( current ).next();
			
			if( next ){
				$( next ).addClassName('active');
			}
			else
			{
				this.selectFirstItem();
			}
		}				
	},
	
	// INTERNAL CALL
	selectFirstItem: function()
	{
		if( !$( this.list ).visible() ){ return; }
		this.unselectAll();
		
		$( this.list ).firstDescendant().addClassName('active');		
	},
	
	// INTERNAL CALL
	selectLastItem: function()
	{
		if( !$( this.list ).visible() ){ return; }
		this.unselectAll();
		
		var d = $( this.list ).immediateDescendants();
		var l = d[ d.length -1 ];
		
		if( l )
		{
			$( l ).addClassName('active');
		}
	},
	
	unselectAll: function()
	{
		$( this.list ).childElements().invoke('removeClassName', 'active');
	},
	
	// Ze goggles are blurry!
	timerEventBlur: function(e)
	{
		window.clearTimeout( this.timer );
		this.eventBlur.bind(this).delay( 0.6, e );
	},
	
	// Phew, ze goggles are focussed again
	timerEventFocus: function(e)
	{
		this.timer = this.eventFocus.bind(this).delay(0.4, e);
	},
	
	eventBlur: function(e)
	{
		if( $( this.list ).visible() )
		{
			var effect = new Effect.Fade( $(this.list), { duration: 0.3 } );
		}
	},
	
	eventFocus: function(e)
	{
		if( !this.observing ){ return; }
		
		// Keep loop going
		this.timer = this.eventFocus.bind(this).delay(0.4, e);
		
		var curValue = this.getCurrentName();
		if( curValue == this.last_string ){ return; }
		
		if( curValue.length < this.options.min_chars ){
			// Hide list if necessary
			if( $( this.list ).visible() )
			{
				var effect = new Effect.Fade( $( this.list ), { duration: 0.3, afterFinish: function(){ $( this.list ).update() }.bind(this) } );
			}
			
			return;
		}
		
		this.last_string = curValue;
		
		// Cached?
		json = this.cacheRead( curValue );
		
		if( json == false ){
			// No results yet, get them
			var request = new Ajax.Request( this.options.url + escape( curValue ),
								{
									method: 'get',
									evalJSON: 'force',
									onSuccess: function(t)
									{
										if( Object.isUndefined( t.responseJSON ) )
										{
											// Well, this is bad.
											Debug.error("Invalid response returned from the server");
											return;
										}
										
										if( t.responseJSON['error'] )
										{
											switch( t.responseJSON['error'] )
											{
												case 'requestTooShort':
													Debug.warn("Server said request was too short, skipping...");
												break;
												default:
													Debug.error("Server returned an error: " + t.responseJSON['error']);
												break;
											}
											
											return false;
										}
										
										if( t.responseText != "[]" )
										{
										
											// Seems to be OK!
										
											this.cacheWrite( curValue, t.responseJSON );
											this.updateAndShow( t.responseText.evalJSON() );
										}
									}.bind( this )
								}
							);
		}
		else
		{
			this.updateAndShow( json );
		}				
		
		//Debug.write( curValue );
	},
	
	updateAndShow: function( json )
	{
		if( !json ){ return; }
		
		this.updateList( json );

		if( !$( this.list ).visible() )
		{
			var effect = new Effect.Appear( $( this.list ), { duration: 0.3, afterFinish: function(){ this.selectFirstItem(); }.bind(this) } );
		}
	},
	
	cacheRead: function( value )
	{
		if( this.options.global_cache != false )
		{
			if( !Object.isUndefined( this.options.global_cache[ value ] ) ){
				Debug.info("Read from global cache");
				return this.options.global_cache[ value ];
			}
		}
		else
		{
			if( !Object.isUndefined( this.internal_cache[ value ] ) ){
				Debug.info("Read from internal cache");
				return this.internal_cache[ value ];
			}
		}
		
		return false;
	},
	
	cacheWrite: function( key, value )
	{
		if( this.options.global_cache !== false ){
			this.options.global_cache[ key ] = value;
		} else {
			this.internal_cache[ key ] = value;
		}
		
		return true;
	},
	
	getCurrentName: function()
	{
		if( this.options.multibox )
		{
			// some logic to get current name
			if( $F( this.obj ).indexOf(',') === -1 ){
				return $F( this.obj ).strip();
			}
			else
			{
				var pieces = $F( this.obj ).split(',');
				var lastPiece = pieces[ pieces.length - 1 ];
				
				return lastPiece.strip();
			}
		}
		else
		{
			return $F( this.obj ).strip();
		}
	},
	
	buildList: function()
	{
		if( $( this.id + '_ac' ) )
		{
			return;
		}
		
		var ul = this.options.templates.wrap.evaluate({ id: this.id + '_ac' });
		$( this.id ).insert( {after: ul} );
		
		// Get textbox position
		var dims = $( this.id ).getDimensions();
		var pos = $( this.id ).cumulativeOffset();
		
		$( this.id + '_ac' ).setStyle('position: absolute; top: ' + (pos.top + dims.height) + 'px; left: ' + pos.left + 'px;').hide();
		
		
		this.list = $( this.id + '_ac' );
	},
	
	updateList: function( json )
	{
		if( !json || !$( this.list ) ){ return; }
	
		var newitems ='';
		this.items = $A();
		
		json = $H( json );
		
		json.each( function( item )
			{		
				var li = this.options.templates.item.evaluate({ id: this.id + '_ac_item_' + item.key,
				 												itemid: item.key,
				 												itemvalue: item.value['name'],
				 												img: item.value['img'] || '',
																img_w: item.value['img_w'] || '',
																img_h: item.value['img_h'] || ''
															});
				this.items[ item.key ] = item.value['name'];
	
				newitems = newitems + li;
			}.bind(this)
		);
		
		$( this.list ).update( newitems );
		$( this.list ).immediateDescendants().each( function(elem){
			$( elem ).observe('mouseover', this.selectThisItem.bindAsEventListener(this));
			$( elem ).observe('click', this.selectCurrentItem.bindAsEventListener(this));
			$( elem ).setStyle('cursor: pointer');
		}.bind(this));
		
		if( $( this.list ).visible() )
		{
			this.selectFirstItem();
		}
	}
				
});

/* ===================================================================================================== */
/* Values for the IPB text editor */

IPBoard.prototype.editor_values = $H({
	'templates': 		$A(),
	'colors_perrow': 	8,
	'colors': [ 		'000000' ,
						'A0522D' ,
						'556B2F' ,
						'006400' ,
						'483D8B' ,
						'000080' ,
						'4B0082' ,
						'2F4F4F' ,
						'8B0000' ,
						'FF8C00' ,
						'808000' ,
						'008000' ,
						'008080' ,
						'0000FF' ,
						'708090' ,
						'696969' ,
						'FF0000' ,
						'F4A460' ,
						'9ACD32' ,
						'2E8B57' ,
						'48D1CC' ,
						'4169E1' ,
						'800080' ,
						'808080' ,
						'FF00FF' ,
						'FFA500' ,
						'FFFF00' ,
						'00FF00' ,
						'00FFFF' ,
						'00BFFF' ,
						'9932CC' ,
						'C0C0C0' ,
						'FFC0CB' ,
						'F5DEB3' ,
						'FFFACD' ,
						'98FB98' ,
						'AFEEEE' ,
						'ADD8E6' ,
						'DDA0DD' ,
						'FFFFFF'
					],
	
	// You can add new fonts here if you wish, HOWEVER, if you use
	// non-standard fonts, users without those fonts on their computer
	// will not see them. The default list below has the generally accepted
	// safe fonts; add others at your own risk! 
	'primary_fonts': $H({ 	arial:					"Arial",
							arialblack:				"Arial Black",
							arialnarrow:			"Arial Narrow",
							bookantiqua:			"Book Antiqua",
							centurygothic:			"Century Gothic",
							comicsansms:			"Comic Sans MS",
							couriernew:				"Courier New",
							franklingothicmedium:	"Franklin Gothic Medium",
							garamond:				"Garamond",
							georgia:				"Georgia",
							impact:					"Impact",
							lucidaconsole:			"Lucida Console",
							lucidasansunicode:		"Lucida Sans Unicode",
							microsoftsansserif:		"Microsoft Sans Serif",
							palatinolinotype:		"Palatino Linotype",
							tahoma:					"Tahoma",
							timesnewroman:			"Times New Roman",
							trebuchetms:			"Trebuchet MS",
							verdana:				"Verdana"
					}),
	'font_sizes': $A([ 1, 2, 3, 4, 5, 6, 7 ]),
	'other_styles': $H({
			acronym: [
				'Acronym', 	// Display as
				'acronym', 	// Tag name
				true,		// Has option?
				"[acronym='Laugh Out Loud']lol[/acronym]",	// Example
				"Acronym", // Text for value
				"Full text"	// Text for option
			],
			topiclink: [
				'Topic Link',
				'topic',
				true,
				'[topic=100]Click me![/topic]',
				"Link text",
				"Topic ID"
			],
			postlink: [
				'Post Link',
				'post',
				true,
				'[post=100]Click me![/topic]',
				"Link Text",
				"Post ID"
			],
			memberlink: [
				'Member Link',
				'member',
				true,
				"[member=Matt]View Matt's Profile[/member]",
				"Link Text",
				"Member ID"
			],
			spoiler: [
				'Spoiler Text',
				'spoiler',
				false,
				"[spoiler]This text is secret![/spoiler]",
				"Text to obscure"
			]
		})
				
});

/* ===================================================================================================== */
/* Extended objects */

// Extend RegExp with escape
Object.extend( RegExp, { 
	escape: function(text)
	{
		if (!arguments.callee.sRE)
		{
		   	var specials = [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$' ];
		   	arguments.callee.sRE = new RegExp( '(\\' + specials.join('|\\') + ')' ); // IMPORTANT: dont use g flag
		}
		return text.replace(arguments.callee.sRE, '\\$1');
	}
});

// Extend String with URL UTF-8 escape
String.prototype.encodeUrl = function()
{
		text = this;
		var regcheck = text.match(/[\x90-\xFF]/g);
		
		if ( regcheck )
		{
			for (var i = 0; i < i.length; i++)
			{
				text = text.replace(regcheck[i], '%u00' + (regcheck[i].charCodeAt(0) & 0xFF).toString(16).toUpperCase());
			}
		}
	
		return escape(text).replace(/\+/g, "%2B").replace(/%20/g, '+').replace(/\*/g, '%2A').replace(/\//g, '%2F').replace(/@/g, '%40');
};

// Extend Date object with a function to check for DST
Date.prototype.getDST = function()
{
	var beginning	= new Date( "January 1, 2008" );
	var middle		= new Date( "July 1, 2008" );
	var difference	= middle.getTimezoneOffset() - beginning.getTimezoneOffset();
	var offset		= this.getTimezoneOffset() - beginning.getTimezoneOffset();
	
	if( difference != 0 )
	{
		return (difference == offset) ? 1 : 0;
	}
	else
	{
		return 0;
	}
};

/* ==================================================================================================== */
/* IPB3 JS Loader */

var Loader = {
	require: function( name )
	{
		document.write("<script type='text/javascript' src='" + name + ".js'></script>");
	},
	boot: function()
	{
		$A( document.getElementsByTagName("script") ).findAll(
			function(s)
			{
  				return (s.src && s.src.match(/ipb\.js(\?.*)?$/))
			}
		).each( 
			function(s) {
  				var path = s.src.replace(/ipb\.js(\?.*)?$/,'');
  				var includes = s.src.match(/\?.*load=([a-z0-9_,]*)/);
				if( includes[1] )
				{
					includes[1].split(',').each(
						function(include)
						{
							if( include )
							{
								Loader.require( path + "ips." + include );
							}
						}
					)
				}
			}
		);
	}
}

/* ===================================================================================================== */
/* IPB3 JS Debugging */

var Debug = {
	write: function( text )
	{
		if( jsDebug && !Object.isUndefined(window.console) )
		{
			console.log( text );
		}
	},
	dir: function( values )
	{
		if( jsDebug && !Object.isUndefined(window.console) )
		{
			console.dir( values );
		}
	},
	error: function( text )
	{
		if( jsDebug && !Object.isUndefined(window.console) )
		{
			console.error( text );
		}
	},
	warn: function( text )
	{
		if( jsDebug && !Object.isUndefined(window.console) )
		{
			console.warn( text );
		}
	},
	info: function( text )
	{
		if( jsDebug && !Object.isUndefined(window.console) )
		{
			console.info( text );
		}
	}
}