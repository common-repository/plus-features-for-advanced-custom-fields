
(function ($, undefined) {
  if(typeof acf !== "undefined" && typeof acf.Field !== "undefined" && typeof acf.Field.extend === "function") {
    var Field = acf.Field.extend({
      type: 'link',
      events: {
        'click a[data-name="add"]': 'onClickEdit',
        'click a[data-name="edit"]': 'onClickEdit',
        'click a[data-name="remove"]': 'onClickRemove',
        'change .link-node': 'onChange'
      },
      $control: function () {
        return this.$('.acf-link');
      },
      $node: function () {
        return this.$('.link-node');
      },
      getValue: function () {
        //ok
        //console.log('get value called');
        // vars
        var $node = this.$node();

        // return false if empty
        if (!$node.attr('href')) {
          return false;
        }
        
        // return
        return {
          title: $node.html(),
          url: $node.attr('href'),
          target: $node.attr('target'),
          nofollow: $node.attr('nofollow')// acfp added.
        };
      },
      setValue: function (val) {
        //ok
        //called on submit in wp link modal
        // default
        val = acf.parseArgs(val, {
          title: '',
          url: '',
          target: '',
          nofollow:''// acfp added.
        });

        // vars
        var $div = this.$control();
        var $node = this.$node();

        // remove class
        $div.removeClass('-value -external');

        // add class
        if (val.url) $div.addClass('-value');
        if (val.target === '_blank') $div.addClass('-external');

        // update text
        this.$('.link-title').html(val.title);
        this.$('.link-url').attr('href', val.url).html(val.url);

        // update node
        $node.html(val.title);
        $node.attr('href', val.url);
        $node.attr('target', val.target);
        $node.attr('nofollow', val.nofollow);

        
        // update inputs
        this.$('.input-title').val(val.title);
        this.$('.input-target').val(val.target);
        this.$('.input-nofollow').val(val.nofollow);
        this.$('.input-url').val(val.url).trigger('change');
      },
      onClickEdit: function (e, $el) {
        //console.log('onClickEdit');
        //console.log( this.$node().attr('nofollow'));
        acf.wpLink.open(this.$node());
      },
      onClickRemove: function (e, $el) {
        this.setValue(false);
      },
      onChange: function (e, $el) {
        //ok
        // get the changed value
        var val = this.getValue();
        
        // update inputs
        this.setValue(val);
      }
    });
  
    acf.registerFieldType(Field);

    // manager
    acf.wpLink = new acf.Model({
      getNodeValue: function () {
        var $node = this.get('node');
        //console.log('getNodeValue');
        //console.log( $node.attr('nofollow'));
        return {
          title: acf.decode($node.html()),
          url: $node.attr('href'),
          target: $node.attr('target'),
          nofollow: $node.attr('nofollow')//acfp added.
        };
      },
      setNodeValue: function (val) {
        var $node = this.get('node');
        $node.text(val.title);
        $node.attr('href', val.url);
        $node.attr('target', val.target);
        $node.attr('nofollow', val.nofollow);//acfp added.
        $node.trigger('change');
      },
      getInputValue: function () {
        return {
          title: $('#wp-link-text').val(),
          url: $('#wp-link-url').val(),
          target: $('#wp-link-target').prop('checked') ? '_blank' : '',
          nofollow: $('#wp-link-nofollow').prop('checked') ? 'nofollow' : ''//acfp added.
        };
      },
      setInputValue: function (val) {
        $('#wp-link-text').val(val.title);
        $('#wp-link-url').val(val.url);
        $('#wp-link-target').prop('checked', val.target === '_blank');
        $('#wp-link-nofollow').prop('checked', val.nofollow === 'nofollow');//acfp added.
      },
      open: function ($node) {
        // add events
        this.on('wplink-open', 'onOpen');
        this.on('wplink-close', 'onClose');
  
        // set node
        this.set('node', $node);
  
        // create textarea
        var $textarea = $('<textarea id="acf-link-textarea" style="display:none;"></textarea>');
        $('body').append($textarea);
  
        // vars
        var val = this.getNodeValue();
  
        // open popup
        wpLink.open('acf-link-textarea', val.url, val.title, null);
      },
      onOpen: function () {
        // always show title (WP will hide title if empty)
        $('#wp-link-wrap').addClass('has-text-field');
  
        // set inputs
        var val = this.getNodeValue();
        this.setInputValue(val);
  
        // Update button text.
        if (val.url && wpLinkL10n) {
          $('#wp-link-submit').val(wpLinkL10n.update);
        }
      },
      close: function () {
        wpLink.close();
      },
      onClose: function () {
        // Bail early if no node.
        // Needed due to WP triggering this event twice.
        if (!this.has('node')) {
          return false;
        }
  
        // Determine context.
        var $submit = $('#wp-link-submit');
        var isSubmit = $submit.is(':hover') || $submit.is(':focus');
  
        // Set value
        if (isSubmit) {
          var val = this.getInputValue();
          this.setNodeValue(val);
        }
  
        // Cleanup.
        this.off('wplink-open');
        this.off('wplink-close');
        $('#acf-link-textarea').remove();
        this.set('node', null);
      }
    
    });
  }

})(jQuery);
