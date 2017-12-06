<div class="formbuilder-wrapper">
    <script type="text/x-tmpl" class="textfield-template">
        <tr>
            <td>
                Text field
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="textarea-template">
        <tr>
            <td>
                Textarea
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="emailfield-template">
        <tr>
            <td>
                Email field
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="checkbox-template">
        <tr>
            <td>
                Checkbox
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="checkboxset-template">
        <tr>
            <td>
                Checkboxset
            </td>
            <td>
                <table class="formbuilder-multipleoptions">
                    <tr>
                        <td><input type="text" class="text" placeholder="Value" name="value" /></td>
                        <td><input type="text" class="text" placeholder="Label" name="label" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="radiogroup-template">
        <tr>
            <td>
                Radiogroup
            </td>
            <td>
                <table class="formbuilder-multipleoptions">
                    <tr>
                        <td><input type="text" class="text" placeholder="Value" name="value" /></td>
                        <td><input type="text" class="text" placeholder="Label" name="label" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="dropdown-template">
        <tr>
            <td>
                Dropdown
            </td>
            <td>
                <table class="formbuilder-multipleoptions">
                    <tr>
                        <td><input type="text" class="text" placeholder="Value" name="value" /></td>
                        <td><input type="text" class="text" placeholder="Label" name="label" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </script>

    <div class="formbuilder-hidden formbuilder-textarea">
        <textarea $AttributesHTML>$ValueEntities.RAW</textarea>
    </div>
    <div class="formbuilder-toolbar">
        <select class="formbuilder-fieldtype">
            <option value="textfield">Text field</option>
            <option value="textarea">Textarea</option>
            <option value="emailfield">Email field</option>
            <option value="checkbox">Checkbox</option>
            <option value="checkboxset">Checkboxset</option>
            <option value="radiogroup">Radiogroup</option>
            <option value="dropdown">Dropdown</option>
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
