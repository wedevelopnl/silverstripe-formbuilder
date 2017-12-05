<div class="formbuilder-wrapper">
    <script type="text/x-tmpl" class="textfield-template">
        <tr>
            <td>
                Text field
            </td>
            <td>
                -
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="emailfield-template">
        <tr>
            <td>
                Email field
            </td>
            <td>
                -
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="checkbox-template">
        <tr>
            <td>
                Checkbox
            </td>
            <td>
                <label><input type="checkbox" /> Default checked</label>
            </td>
        </tr>
    </script>

    <div class="formbuilder-hidden formbuilder-textarea">
        <textarea $AttributesHTML>$ValueEntities.RAW</textarea>
    </div>
    <div class="formbuilder-toolbar">
        <select class="formbuilder-fieldtype">
            <option value="textfield">Text field</option>
            <option value="emailfield">Email field</option>
            <option value="checkbox">Checkbox</option>
        </select>
        <a class="btn btn-primary tool-button font-icon-plus formbuilder-addbutton" href="#">Add field</a>
    </div>
    <table class="formbuilder-fields table" style="display: none;">
        <thead>
            <tr>
                <th style="width: 1%">&nbsp;</th>
                <th style="width: 1%">Field type</th>
                <th style="width: 50%">Field title</th>
                <th style="width: 50%">Options</th>
                <th style="width: 1%">Required</th>
                <th style="width: 1%">&nbsp;</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
