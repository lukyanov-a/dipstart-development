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
                    <select class="form-control" name="Filters[filter][column][]" onchange="selectByColumn(this);">
                        <?php foreach ($columns as $column) {
                            if($column->name!='password' && $column->name!='activkey') { ?>
                                <option value="<?php echo $column->name; ?>" <?php if ($column->name==$item['column']) echo 'selected'; ?>>
                                    <?php echo Yii::t('site',$column->name); ?>
                                </option>
                            <?php } ?>
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
                <td class="inputReplace">
                    <?php
                    $this->renderPartial('columnValue',array(
                        'column'=> $item['column'],
                        'table' => $table,
                        'value' => $item['value']
                    )); ?>
                </td>
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
                <select class="form-control" name="Filters[filter][column][]" onchange="selectByColumn(this);">
                <?php foreach ($columns as $column) {
                    if($column->name!='password' && $column->name!='activkey') { ?>
                        <option value="<?php echo $column->name; ?>" <?php //if ($column) echo 'selected'; ?>>
                            <?php echo Yii::t('site',$column->name); ?>
                        </option>
                    <?php } ?>
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
            <td class="inputReplace"><?php
                $this->renderPartial('columnValue',array(
                    'column'=> 'id',
                    'table' => $table,
                    'value' => $item['value']
                )); ?></td>
            <td class="operand">
                <?php //if($num>0) echo '<a href="#" class="del_row">-</a>'; ?>
            </td>
            <td><a href="#" class="add_row">+</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>