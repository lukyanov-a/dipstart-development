<?php
/**
 * @var Templates[] $templates
 * @var array $templateNames
 * @var int $type
 */
echo CHtml::dropDownList(sprintf('template_type_%s_names', $type), '', $templateNames, [
    'class' => 'chat_template_names',
    'data-type' => $type
]);
$firstTemplateName = reset($templateNames);
foreach ($templateNames as $index => $templateName) {
    $template = array_filter($templates, function ($val) use ($templateName) {
        return $val['name'] === $templateName;
    });
    $hidden = $templateName === $firstTemplateName ? '' : ' hidden';
    echo CHtml::dropDownList(sprintf('template_type_%s_%s', $type, $index), '', CHtml::listData($template, 'text', 'title'), [
        'class' => sprintf('chat_templates chat_templates_%s%s', (string)$type, $hidden),
        'data-name' => $templateName
    ]);
}
?>