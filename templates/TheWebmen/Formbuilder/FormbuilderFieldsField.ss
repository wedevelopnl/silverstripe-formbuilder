<div class="formbuilder-wrapper" data-confirm-text="<%t Formbuilder.CONFIRM_TEXT "Are you sure?" %>">
    <script type="text/x-tmpl" class="textfield-template">
        <tr>
            <td>
                <%t Formbuilder.TEXTFIELD "Textfield" %>
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="textarea-template">
        <tr>
            <td>
                <%t Formbuilder.TEXTAREA "Textarea" %>
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="emailfield-template">
        <tr>
            <td>
                <%t Formbuilder.EMAILFIELD "Emailfield" %>
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="checkbox-template">
        <tr>
            <td>
                <%t Formbuilder.CHECKBOX "Checkbox" %>
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="checkboxset-template">
        <tr>
            <td>
                <%t Formbuilder.CHECKBOXSET "Checkboxset" %>
            </td>
            <td>
                <table class="formbuilder-multipleoptions">
                    <tr>
                        <td><input type="text" class="text" placeholder="<%t Formbuilder.VALUE "Value" %>" name="value" /></td>
                        <td><input type="text" class="text" placeholder="<%t Formbuilder.LABEL "Label" %>" name="label" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="radiogroup-template">
        <tr>
            <td>
                <%t Formbuilder.RADIOGROUP "Radiogroup" %>
            </td>
            <td>
                <table class="formbuilder-multipleoptions">
                    <tr>
                        <td><input type="text" class="text" placeholder="<%t Formbuilder.VALUE "Value" %>" name="value" /></td>
                        <td><input type="text" class="text" placeholder="<%t Formbuilder.LABEL "Label" %>" name="label" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </script>
    <script type="text/x-tmpl" class="dropdown-template">
        <tr>
            <td>
                <%t Formbuilder.DROPDOWN "Dropdown" %>
            </td>
            <td>
                <table class="formbuilder-multipleoptions">
                    <tr>
                        <td><input type="text" class="text" placeholder="<%t Formbuilder.VALUE "Value" %>" name="value" /></td>
                        <td><input type="text" class="text" placeholder="<%t Formbuilder.LABEL "Label" %>" name="label" /></td>
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
            <option value="textfield"><%t Formbuilder.TEXTFIELD "Textfield" %></option>
            <option value="textarea"><%t Formbuilder.TEXTAREA "Textarea" %></option>
            <option value="emailfield"><%t Formbuilder.EMAILFIELD "Emailfield" %></option>
            <option value="checkbox"><%t Formbuilder.CHECKBOX "Checkbox" %></option>
            <option value="checkboxset"><%t Formbuilder.CHECKBOXSET "Checkboxset" %></option>
            <option value="radiogroup"><%t Formbuilder.RADIOGROUP "Radiogroup" %></option>
            <option value="dropdown"><%t Formbuilder.DROPDOWN "Dropdown" %></option>
        </select>
        <a class="btn btn-primary tool-button font-icon-plus formbuilder-addbutton" href="#">Add field</a>
    </div>
    <table class="formbuilder-fields table" style="display: none;">
        <thead>
            <tr>
                <th style="width: 1%">&nbsp;</th>
                <th style="width: 1%"><%t Formbuilder.FIELD_TYPE "Field type" %></th>
                <th style="width: 50%"><%t Formbuilder.FIELD_TITLE "Field title" %></th>
                <th style="width: 50%"><%t Formbuilder.OPTIONS "Options" %></th>
                <th style="width: 1%"><%t Formbuilder.REQUIRED "Required" %></th>
                <th style="width: 1%">&nbsp;</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
