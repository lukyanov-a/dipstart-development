<table>
    <thead>
    <tr>
        <th><?php echo Yii::t('site','Column');?></th>
        <th><?php echo Yii::t('site','Operator');?></th>
        <th><?php echo Yii::t('site','Value');?></th>
    </tr>
    </thead>
    <tbody>
    <?php if($filter) {
        $num = 0;
        foreach ($filter as $key=>$item) { ?>
            <tr>
                <td>
                    <?php if($num==0) echo '<input type="hidden" name="Filters[filter][operand][]" value="" class="first-operand">'; ?>
                    <select class="form-control" name="Filters[filter][column][]">
                        <?php foreach ($columns as $column) { ?>
                            <option value="<?php echo $column->name; ?>" <?php if ($column->name==$item['column']) echo 'selected'; ?>>
                                <?php echo $column->name; ?>
                            </option>
                        <?php } ?>
                    </select></td>
                <td><select class="form-control" name="Filters[filter][operator][]">
                        <option value="=" <?php if ($item['operator'] == '=') echo 'selected'; ?>>=</option>
                        <option value=">" <?php if ($item['operator'] == '>') echo 'selected'; ?>>></option>
                        <option value="<" <?php if ($item['operator'] == '<') echo 'selected'; ?>><</option>
                        <option value="<=" <?php if ($item['operator'] == '<=') echo 'selected'; ?>><=</option>
                        <option value=">=" <?php if ($item['operator'] == '>=') echo 'selected'; ?>>>=</option>
                        <option value="<>" <?php if ($item['operator'] == '<>') echo 'selected'; ?>>!=</option>
                        <option value="LIKE" <?php if ($item['operator'] == 'LIKE') echo 'selected'; ?>>Содержит</option>
                    </select></td>
                <td><input size="30" name="Filters[filter][value][]" value="<?php echo $item['value']; ?>" type="text"></td>
                <td class="operand">
                    <?php if(count($filter)>1 && $num!=count($filter)-1) { ?>
                        <select class="form-control" name="Filters[filter][operand][]">
                            <option value="AND" <?php if ($filter[$key+1]['operand'] == 'AND') echo 'selected'; ?>>AND</option>
                            <option value="OR" <?php if ($filter[$key+1]['operand'] == 'OR') echo 'selected'; ?>>OR</option>
                        </select>
                    <?php } ?>
                </td>
                <td>
                    <?php if(count($filter)>1 && $num!=count($filter)-1) echo '<a href="#" class="del_row">-</a>';
                    else echo '<a href="#" class="add_row">+</a>'; ?>
                </td>
            </tr>
    <?php
            $num++;
        }
    } else { ?>
        <tr>
            <td>
                <input type="hidden" name="Filters[filter][operand][]" value="" class="first-operand">
                <select class="form-control" name="Filters[filter][column][]">
                <?php foreach ($columns as $column) { ?>
                    <option value="<?php echo $column->name; ?>" <?php //if ($column) echo 'selected'; ?>>
                        <?php echo $column->name; ?>
                    </option>
                <?php } ?>
            </select></td>
            <td><select class="form-control" name="Filters[filter][operator][]">
                    <option value="=" <?php if ($item['operator'] == '=') echo 'selected'; ?>>=</option>
                    <option value=">" <?php if ($item['operator'] == '>') echo 'selected'; ?>>></option>
                    <option value="<" <?php if ($item['operator'] == '<') echo 'selected'; ?>><</option>
                    <option value="<=" <?php if ($item['operator'] == '<=') echo 'selected'; ?>><=</option>
                    <option value=">=" <?php if ($item['operator'] == '>=') echo 'selected'; ?>>>=</option>
                    <option value="<>" <?php if ($item['operator'] == '<>') echo 'selected'; ?>>!=</option>
                    <option value="LIKE" <?php if ($item['operator'] == 'LIKE') echo 'selected'; ?>>Содержит</option>
                </select></td>
            <td><input size="30" name="Filters[filter][value][]" value="<?php echo $item['value']; ?>" type="text"></td>
            <td class="operand">
                <?php //if($num>0) echo '<a href="#" class="del_row">-</a>'; ?>
            </td>
            <td><a href="#" class="add_row">+</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>