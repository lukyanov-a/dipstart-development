<?php
switch ($table) {
    case 'Projects':
    case 'CurrentProjects':
    case 'DoneProjects':
        $model = 'Project';
        $table = 'Projects';
        break;
    case 'User':
        $model = 'User';
        break;
    case 'Payment':
        $model = 'Payment';
        break;
}

if(($column=='user_id' && $table=='Projects') || ($column=='executor' && $table=='Projects')
    || ($column=='manager' && $table=='Projects') || ($column=='user' && $table=='Projects')) {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));?>
    <select class="form-control" name="Filters[filter][value][]">
        <?php foreach ($items as $item) {
            if($item->$column) {
                $text = User::model()->findByPk($item->$column);
                echo '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text->username . '</option>';
            }
        }
        echo '<option value="0" ' . ($value == $item->$column ? 'selected' : '') . '>' . Yii::t('site', 'no') . '</option>';
        ?>
    </select>
<?php } elseif(($column=='status' && $table=='Projects')) {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));?>
    <select class="form-control" name="Filters[filter][value][]">
        <?php foreach ($items as $item) {
            if($item->$column) {
                $text = ProjectStatus::model()->findByPk($item->$column);
                echo '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text->status . '</option>';
            }
        } ?>
    </select>
<?php } elseif(($column=='specials' && $table=='Projects')) {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));?>
    <select class="form-control" name="Filters[filter][value][]">
        <?php foreach ($items as $item) {
            if($item->$column) {
                $text = Catalog::model()->findByPk($item->$column);
                echo '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text->cat_name . '</option>';
            }
        } ?>
    </select>
<?php } elseif(($column=='technicalspec' && $table=='Projects')) {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));?>
    <select class="form-control" name="Filters[filter][value][]">
        <?php foreach ($items as $item) {
            if($item->$column) {
                $text = ClassAction::model()->findByPk($item->$column);
                echo '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text->name . '</option>';
            }
        }
        echo '<option value="0" ' . ($value == $item->$column ? 'selected' : '') . '>' . Yii::t('site', 'no') . '</option>'; ?>
    </select>
<?php } elseif(($column=='parent_id' && $table=='Projects') || ($column=='order_id' && $table=='Payment')) {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));?>
    <select class="form-control" name="Filters[filter][value][]">
        <?php foreach ($items as $item) {
            if($item->$column) {
                $text = Zakaz::model()->findByPk($item->$column);
                echo '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text->title . '</option>';
            }
        }
        echo '<option value="0" ' . ($value == $item->$column ? 'selected' : '') . '>' . Yii::t('site', 'no') . '</option>'; ?>
    </select>
<?php } elseif(($column=='executor_event' && $table=='Projects')) {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));?>
    <select class="form-control" name="Filters[filter][value][]">
        <?php foreach ($items as $item) {
            if($item->$column) {
                $text = Zakaz::model()->executorEventsArr()[$item->$column];
                echo '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text . '</option>';
            }
        }
        echo '<option value="0" ' . ($value == $item->$column ? 'selected' : '') . '>' . Yii::t('site', 'no') . '</option>'; ?>
    </select>
<?php } elseif(($column=='customer_event' && $table=='Projects')) {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));?>
    <select class="form-control" name="Filters[filter][value][]">
        <?php foreach ($items as $item) {
            if($item->$column) {
                $text = Zakaz::model()->customerEventsArr()[$item->$column];
                echo '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text . '</option>';
            }
        }
        echo '<option value="0" ' . ($value == $item->$column ? 'selected' : '') . '>' . Yii::t('site', 'no') . '</option>'; ?>
    </select>
<?php } elseif(($column=='payment_type' && $table=='Payment')) {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));?>
    <select class="form-control" name="Filters[filter][value][]">
        <?php foreach ($items as $item) {
            if($item->$column) {
                $text = Payment::model()->types()[$item->$column];
                echo '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text . '</option>';
            }
        }
        echo '<option value="0" ' . ($value == $item->$column ? 'selected' : '') . '>' . Yii::t('site', 'no') . '</option>'; ?>
    </select>
<?php } elseif(($column=='approve' && $table=='Payment')) {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));?>
    <select class="form-control" name="Filters[filter][value][]">
        <?php foreach ($items as $item) {
            if($item->$column) {
                $text = array('0' => Yii::t('site','New'), '1' => Yii::t('site','Confirmed'), '2' => Yii::t('site','Rejected'));
                $text = $text[$item->$column];
                echo '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text . '</option>';
            }
        }
        echo '<option value="0" ' . ($value == $item->$column ? 'selected' : '') . '>' . Yii::t('site','New') . '</option>'; ?>
    </select>
<?php } /*elseif(($column=='create_at' && $table=='User') || ($column=='lastvisit_at' && $table=='User')) { ?>
    <input id="sdfsdf" name="Filters[filter][value][]" type="text" value="<?php echo $value; ?>" class="hasDatepicker">
 <?php }*/
elseif(($column=='superuser' && $table=='User') || ($column=='status' && $table=='User')
    || ($column=='is_active' && $table=='Projects')) { ?>
    <select class="form-control" name="Filters[filter][value][]">
        <option value="1" <?php if ($value) echo 'selected'; ?>><?php echo Yii::t('site', 'yes'); ?></option>
        <option value="0" <?php if (!$value) echo 'selected'; ?>><?php echo Yii::t('site', 'no'); ?></option>
    </select>
<?php } else {
    $items = $model::model()->findAll(array('order'=>$column, 'group'=>$column));
    $not_find_val = true;
    $option = '';
    foreach ($items as $item) {
        if($value==$item->$column) $not_find_val = false;
        $text = $item->$column;
        if(mb_strlen($text)>150) $text = substr($text, 0, 150).'...';

        if($item->$column) {
            $option .= '<option value="' . $item->$column . '" ' . ($value == $item->$column ? 'selected' : '') . '>' . $text . '</option>';
        }
    }
    if ($option=='') $not_find_val = true;
    ?>
    <select class="form-control" name="<?php echo $not_find_val ? 'Filters[filter][value][]' : '_temp_filteres'; ?>" onchange="selectByValue(this);">
        <?php echo $option; ?>
        <option value="other" <?php if ($not_find_val) echo 'selected'; ?>>
            <?php echo Yii::t('site', 'my_value'); ?>
        </option>
    </select>
    <?php if($not_find_val)
        echo '<input size="30" name="Filters[filter][value][]" value="'.$value.'" type="text">';
    else
        echo '<input size="30" name="_temp_filteres" value="'.$value.'" type="text" style="display: none">';
}