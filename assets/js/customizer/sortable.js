wp.customize.controlConstructor.simple_days_posts_sortable = wp.customize.Control.extend( {
    ready: function() {
      var control = this;
      wp.customize.Control.prototype.ready.call( control );

      
      control.sortableContainer = control.container.find( 'ul.simple_days_posts_sortable_ul' ).first();

      
      control.sortableContainer.sortable({
        
        stop: function() {
          control.updateValue();
        }
      })
    },
    updateValue: function() {
      var control = this,
      newValue = [];
      this.sortableContainer.find( 'li' ).each( function() {
          newValue.push( jQuery( this ).data( 'value' ) );
      });
      control.setting.set( newValue );

    }

} );







jQuery(function() {
  jQuery('.simple_days_posts_sortable_ul').sortable({
  	opacity: 0.6,
    axis: 'y',
    update: function(event, ui) {
      var updateArray =  jQuery(this).sortable("toArray", { attribute: 'value' }).join(",");

    }


  });
});
