<div class="formbuilder-wrapper" data-confirm-text="<%t Formbuilder.CONFIRM_TEXT "Are you sure?" %>">

    $RenderFields.RAW

    <div class="formbuilder-hidden formbuilder-textarea">
        <textarea $AttributesHTML>$ValueEntities.RAW</textarea>
    </div>
    <div class="formbuilder-toolbar">
        <select class="formbuilder-fieldtype">
            <% loop $Fields %>
                <option value="$Field">$Label</option>
            <% end_loop %>
        </select>
        <a class="btn btn-primary tool-button font-icon-plus formbuilder-addbutton" href="#">Add field</a>
    </div>
    <table class="formbuilder-fields table" style="display: none;">
        <thead>
            <tr>
                <th style="width: 1%">&nbsp;</th>
                <th style="width: 1%"><%t Formbuilder.FIELD_TYPE "Field type" %></th>
                <th style="width: 33%"><%t Formbuilder.FIELD_TITLE "Field title" %></th>
                <th style="width: 31%"><%t Formbuilder.OPTIONS "Options" %></th>
                <th style="width: 31%"><%t Formbuilder.INFO_TEXT "Infotext" %></th>
                <th style="width: 1%"><%t Formbuilder.REQUIRED "Required" %></th>
                <th style="width: 1%">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
