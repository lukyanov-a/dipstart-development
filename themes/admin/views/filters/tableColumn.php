<table>
    <tr>
        <th><?php echo Yii::t('site','Column');?></th>
        <th><?php echo Yii::t('site','Operator');?></th>
        <th><?php echo Yii::t('site','Value');?></th>
    </tr>
    <?php foreach ($columns as $column) { ?>
        <tr>
            <td><?php echo $column->name; ?></td>
            <td>
                <select class="form-control" name="Filters[filter][<?php echo $column->name; ?>][operator]">
                    <option value="=" <?php if($filter && isset($filter[$column->name]['operator']) && $filter[$column->name]['operator']=='=') echo 'selected'; ?>>=</option>
                    <option value=">" <?php if($filter && isset($filter[$column->name]['operator']) && $filter[$column->name]['operator']=='>') echo 'selected'; ?>>></option>
                    <option value="<" <?php if($filter && isset($filter[$column->name]['operator']) && $filter[$column->name]['operator']=='<') echo 'selected'; ?>><</option>
                    <option value="<=" <?php if($filter && isset($filter[$column->name]['operator']) && $filter[$column->name]['operator']=='<=') echo 'selected'; ?>><=</option>
                    <option value=">=" <?php if($filter && isset($filter[$column->name]['operator']) && $filter[$column->name]['operator']=='>=') echo 'selected'; ?>>>=</option>
                    <option value="<>" <?php if($filter && isset($filter[$column->name]['operator']) && $filter[$column->name]['operator']=='<>') echo 'selected'; ?>>!=</option>
                    <option value="LIKE" <?php if($filter && isset($filter[$column->name]['operator']) && $filter[$column->name]['operator']=='LIKE') echo 'selected'; ?>>Содержит</option>
                </select>
            </td>
            <td>
                <input size="30" name="Filters[filter][<?php echo $column->name; ?>][value]"  <?php if($filter && isset($filter[$column->name]['value'])) echo 'value="'.$filter[$column->name]['value'].'"'; ?> type="text">
            </td>
        </tr>
    <?php } ?>
</table>