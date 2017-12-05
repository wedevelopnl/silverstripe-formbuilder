(function ($) {
  $.entwine('ss', function ($) {

    $('.formbuilder-wrapper').entwine({

      /**
       * Init
       */
      onmatch: function () {

        var self = this;

        //Add new button
        this.on('click', '.formbuilder-addbutton', function (e) {
          e.preventDefault();
          var _this = $(this);
          var type = _this.prev().val();
          self.addField(type);
          _this.blur();
        });

        //Remove button
        this.on('click', '.formbuilder-remove', function (e) {
          e.preventDefault();
          if(confirm('Are you sure?')){
            $(this).closest('tr').remove();
            self.updateJSON();
          }
        });

        //Sortable
        this.find('.formbuilder-fields tbody').sortable({
          handle: '.formbuilder-sort',
          stop: function(){
            self.updateJSON();
          }
        });

        //Input change
        this.on('change', '.formbuilder-title, .formbuilder-required', function(){
          self.updateJSON();
        });

        //Load saved form
        var textareaVal = this.find('.formbuilder-textarea textarea').val();
        if(textareaVal){
          var fields = JSON.parse(textareaVal);
          var numFields = fields.length;
          for(var i = 0; i < numFields; i++){
            this.addField(fields[i].type, fields[i], true);
          }
          this.find('.formbuilder-fields').show();
        }
      },

      /**
       * Add general data to the row
       * @param row
       * @param type
       */
      prepareRow: function (row, type) {
        var sortCol = $('<td><span class="formbuilder-sort"></span></td>');
        sortCol.append('<input type="hidden" class="formbuilder-type" value="'+type+'" />');
        row.prepend(sortCol);
        row.find('td').eq(1).after('<td><input class="text formbuilder-title" type="text" placeholder="Title" /></td>');
        row.append('<td><input class="formbuilder-required" type="checkbox" /></td>');
        row.append('<td><a href="#" class="btn--icon-md font-icon-trash-bin btn--no-text formbuilder-remove"></a></td>');
      },

      /**
       * Add a field
       * @param type
       * @param data
       * @param silent
       */
      addField: function (type, data, silent) {
        var typeTemplate = this.find('.' + type + '-template');
        var fieldHTML = typeTemplate.html();
        var newRow = $(fieldHTML).hide();
        this.prepareRow(newRow, type);
        this.find('.formbuilder-fields tbody').append(newRow);

        if(data){
          newRow.find('.formbuilder-title').val(data.title);
          if(data.required){
            newRow.find('.formbuilder-required').attr('checked', 'checked');
          }
        }

        if(!silent){
          newRow.fadeIn();
          this.updateJSON();
        }else{
          newRow.show();
        }
      },

      /**
       * Generate the JSON
       */
      updateJSON: function () {
        var textarea = this.find('.formbuilder-textarea textarea');
        var table = this.find('.formbuilder-fields');
        var rows = table.find('tbody tr');
        var json = [];
        if(rows.length){
          table.show();
          rows.each(function(){
            var row = $(this);
            json.push({
              'type': row.find('.formbuilder-type').val(),
              'title': row.find('.formbuilder-title').val(),
              'required': row.find('.formbuilder-required').is(':checked')
            });
          });
        }else{
          table.hide();
        }
        textarea.val(JSON.stringify(json)).trigger('change');
      }

    });

  });
})(jQuery);
