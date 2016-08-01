<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Application\Controller
 */
class IndexController extends AbstractActionController
{
    /**
     * Home page
     * @return ViewModel
     */
    public function indexAction()
    {
        $view = new ViewModel();
        $year = (int) $this->params()->fromRoute('year', date('Y') + 1);

        $expenseDates = $this->FetchExpenseDates($year);

        $view->setVariable('expenseDates', $expenseDates);
        return $view;
    }

    /**
     * Console response
     */
    public function generateAction()
    {
        $outputFolder = dirname(__DIR__) . '/../../../../output/';
        if (!file_exists($outputFolder) || !is_writable($outputFolder)) {
            echo "Error: 'output' folder in project root is missing or is not writable" . "\n";
            die();
        }

        $filename = $this->params()->fromRoute('filename');
        $year = (int) $this->params()->fromRoute('year', date('Y') + 1);

        $expenseDates = $this->FetchExpenseDates($year);

        echo '"Month Name", "1st expenses day", “2nd expenses day”, "Salary day"' . "\n";

        $fp = fopen($outputFolder."$filename.csv", 'w');

        foreach ($expenseDates as $date) {
            $line = '"'.$date['month'].'","'.$date['firstExpensesDay'].'",“'.$date['secondExpensesDay'].'”,"'.$date['salaryDay'].'"' . "\n";
            fputs($fp, $line);
            echo  $line;
        }
        fclose($fp);

        echo "Output file generated at: /output/$filename.csv" . "\n";
    }

}
