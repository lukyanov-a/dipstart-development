<?php

class AnalysisCommand extends CConsoleCommand {
    public function run($args)
    {
        $companies = Company::model()->findAll();
        $catalog = dirname(__FILE__) . '/../../uploads/finance/';
        if (!file_exists($catalog)) mkdir($catalog, 0755);

        $file = $catalog . date("m-Y") . '.csv';
        if (!file_exists($file)) {
            $fp = fopen($file, 'w');
            fputcsv($fp, array(
                Yii::t('site', 'company name'),
                ProjectModule::t('Income'),
                ProjectModule::t('Expenditure'),
                ProjectModule::t('Profit')
            ));

            foreach ($companies as $company) {
                Company::setActive($company);
                if(Company::getAnalysis()) {
                    $model = new Payment('search');
                    $profits = $model->getTotalProfitData(false, true);

                    foreach ($profits as $profit) {
                        fputcsv($fp, array(
                            Company::getName(),
                            $profit['s1'],
                            $profit['s2'],
                            $profit['total'],
                        ));
                    }
                }
            }
            fclose($fp);
        }
    }
}