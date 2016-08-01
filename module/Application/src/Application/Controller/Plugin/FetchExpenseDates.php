<?php
namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Class FetchExpenseDates
 * @package Application\Controller\Plugin
 */
class FetchExpenseDates extends AbstractPlugin
{
    /**
     * @param int $year
     * @return array
     */
    public function __invoke($year)
    {
        $expenseDates = array();

        for ($i = 1; $i <= 12; $i++) {
            $firstDayOfMonth = date("$year-$i-01");
            $fifteenthDayOfMonth = date("$year-$i-16");
            $lastDayOfMonth = date("Y-m-t", strtotime($firstDayOfMonth));

            $expenseDates[$i] = array(
                'month' => date('F', strtotime(date("$year-$i-01"))),
                'firstExpensesDay' => $this->getExpenseDay($firstDayOfMonth),
                'secondExpensesDay' => $this->getExpenseDay($fifteenthDayOfMonth),
                'salaryDay' => $this->getSalaryDay($lastDayOfMonth)
            );
        }

        return $expenseDates;
    }

    /**
     * Calculate Expense Day
     * @param string $dayOfMonth
     * @return string
     */
    protected function getExpenseDay($dayOfMonth)
    {
        $expenseDay = new \DateTime($dayOfMonth);

        if (in_array($expenseDay->format('w'), array(6, 0))) {
            $diff = $expenseDay->format('w') == 6 ? 2 : 1;
            $expenseDay = $expenseDay->modify("+$diff Days");
        }

        return $expenseDay->format('Y-m-d');
    }

    /**
     * Calculate Salary Day
     * @param string $lastDayOfMonth
     * @return string
     */
    protected function getSalaryDay($lastDayOfMonth)
    {
        $salaryDay = new \DateTime($lastDayOfMonth);

        if (in_array($salaryDay->format('w'), array(6, 0))) {
            $diff = $salaryDay->format('w') == 6 ? 1 : 2;
            $salaryDay = $salaryDay->modify("-$diff Days");
        }

        return $salaryDay->format('Y-m-d');
    }

}
