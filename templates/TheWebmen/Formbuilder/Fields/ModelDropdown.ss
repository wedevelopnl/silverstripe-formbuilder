<script type="text/x-tmpl" class="modeldropdown-template">
        <tr>
            <td>
                <%t Formbuilder.MODELDROPDOWN "Model Dropdown" %>
            </td>
            <td>
                <div class="formbuilder-modeldropdown">
                    <select name="value">
                        <% loop $AllowedModelDropdownModels %>
                            <option value="$class">$name</option>
                        <% end_loop %>
                    </select>
                </div>
            </td>
        </tr>
    </script>
