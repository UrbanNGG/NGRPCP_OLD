/************************************************/
/* IPB3 Javascript								*/
/* -------------------------------------------- */
/* ips.menu.js - Me n you class	<3				*/
/* (c) IPS, Inc 2008							*/
/* -------------------------------------------- */
/* Author: Rikki Tissier 						*/
/************************************************/

/* ipb.menus is a menu manager; ipb.Menu is a menu object */

var _menu = window.IPBoard;
_menu.prototype.menus = {
	registered: $H(),
	
	init: function()
	{
		Debug.write("Initializing acp.menu.js");
		document.observe("dom:loaded", function(){
			ipb.menus.initEvents();
		});
	},
	
	initEvents: function()
	{
		// Set document event
		Event.observe( document, 'click', ipb.menus.docCloseAll );
		
		// Auto-find menus
		$$('.ipbmenu').each( function(menu){
			id = menu.identify();
			if( $( id + "_menucontent" ) )
			{
				$$('body')[0].insert( $( id + "_menucontent" ) );
				new ipb.Menu( menu, $( id + "_menucontent" ) );
			}
		});
	},
	
	register: function( source, obj )
	{
		ipb.menus.registered.set( source, obj );
	},
	
	docCloseAll: function( e )
	{
		if( ( !Event.isLeftClick(e) || e.ctrlKey == true || e.keyCode == 91 ) && !Prototype.Browser.IE ) // IE handles this fine anyway
		{
			// This line caused the IPB3 preview to break spectacularly.
			// Left here for the memories. Dont uncomment. Fair warning.
			//Event.stop(e);
		}
		else
		{
			ipb.menus.closeAll( e );
		}
	},
	
	closeAll: function( except )
	{
		ipb.menus.registered.each( function(menu, force){
			if( ( except && menu.key != except ) )
			{
				menu.value.doClose();
			}
		});
	}	
}

ipb.menus.init();

_menu.prototype.Menu = Class.create({
	initialize: function( source, target, options ){
		if( !$( source ) || !$( target ) ){ return; }
		if( !$( source ).id ){
			$( source ).identify();
		}
		this.id = $( source ).id + '_menu';
		this.source = $( source );
		this.target = $( target );
		
		this.options = Object.extend( {
			eventType: 'click',
			stopClose: false,
			offsetX: 0,
			offsetY: 0
		}, arguments[2] || {});
		
		// Set up events
		$( source ).observe( 'click', this.eventClick.bindAsEventListener( this ) );
		$( source ).observe( 'mouseover', this.eventOver.bindAsEventListener( this ) );
		$( target ).observe( 'click', this.targetClick.bindAsEventListener( this ) );
		
		if( this.options.callback )
		{
			this.options.callback.each( function(c){
				$( source ).observe( c.key, c.value );
			});
		}
		
		// Set up target
		$( this.target ).setStyle( 'position: absolute;' ).hide().setStyle( { zIndex: 20000 } );
		$( this.target ).descendants().each( function( elem ){
			$( elem ).setStyle( { zIndex: 20000 } );
		});
		
		ipb.menus.register( $( source ).id, this ); 
	},
	
	doOpen: function()
	{
		var pos = {};
		
		// Position menu to keep it on screen
		var sourcePos = $( this.source ).cumulativeOffset();
		var sourceDim = $( this.source ).getDimensions();
		var screenDim = document.viewport.getDimensions();
		var screenScroll = document.viewport.getScrollOffsets();
		var menuDim = $( this.target ).getDimensions();
				
		// Left
		if( ( sourcePos.left + menuDim.width ) > ( screenDim.width ) ){
			diff = menuDim.width - sourceDim.width;
			pos.left = sourcePos.left - diff + this.options.offsetX;
		} else {
			pos.left = sourcePos.left + this.options.offsetX;
		}
		
		// Top
		if( ( ( sourcePos.top + sourceDim.height ) + menuDim.height ) > ( screenDim.height + screenScroll.top ) ){
			pos.top = sourcePos.top - menuDim.height + this.options.offsetY;
		} else {
			pos.top = sourcePos.top + sourceDim.height + this.options.offsetY;
		}
		
		// Now set pos
		$( this.target ).setStyle( 'top: ' + (pos.top-1) + 'px; left: ' + pos.left + 'px;' );
		
		// And show
		new Effect.Appear( $( this.target ), { duration: 0.2 } );
	},
	
	doClose: function()
	{
		new Effect.Fade( $( this.target ), { duration: 0.3 } );
	},
	
	targetClick: function(e)
	{		
		if( this.options.stopClose )
		{
			Event.stop(e);
		}
	},
	
	eventClick: function(e)
	{
		Event.stop(e);
		
		if( $( this.target ).visible() ){
			this.doClose();
		} else {
			ipb.menus.closeAll( $(this.source).id );
			this.doOpen();
		}
	},
	
	eventOver: function()
	{
		
	}
});
 