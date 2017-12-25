<?php

class AttendanceController extends Controller {

    public function init() {
        $this->redirectionToLogin();
    }

    public function actionAttendanceTest() {
        $allAttendance = Allattendance::model()->findAll();
        foreach ($allAttendance as $value) {
            Attendance::dailyAttendance($value->emp_no, $value->checktime, $value->branch_id, $value->punch_by);
        }
    }

    public function actionViewAttendanceReport() {
        $controller = "Attendance";
        $action = "ViewAttendanceDataReport";

        $reqBasicFields = $this->empBasicFields();
        $reqAttendanceFields = $this->attendanceFields();
        $defaultChecked = array('emp.empno' => 'EMP No', 'emp.epf_no' => 'EPF No', 'emp.emp_name_with_initials' => 'Name With Initials', 'aa.day' => 'Day', 'aa.date_in' => 'Date In', 'aa.punch_in' => 'Punch In', 'aa.date_out' => 'Date Out', 'aa.punch_out' => 'Punch Out');
        $this->render('/search/searchF2', array('controller' => $controller, 'action' => $action, 'reqBasicFields' => $reqBasicFields, 'reqAttendanceFields' => $reqAttendanceFields, 'defaultChecked' => $defaultChecked));
    }

    public function actionViewAttendanceDataReport() {
        $selectedItems = implode(',', json_decode($_POST["selected"], true));
        $selectedLabels = implode(',', json_decode($_POST["selectedLabels"], true));

        $sql = Yii::app()->db->createCommand()
                ->select($selectedItems)
                ->from('att_attendance aa')
                ->getText();


        $limit = $_POST['noOfData'];
        $data = Controller::createSearchForEmployee($sql, 'aa.ref_emp_id', Yii::app()->request->getPost('page'), $limit, 'CAST(emp.epf_no AS DECIMAL),aa.day ASC', 'empbasic');

        $attendanceData = $data['result'];
        $pageCount = $data['count'];
        $currentPage = Yii::app()->request->getPost('page');

        $headers = explode(',', $selectedItems);
        $headersLabels = explode(',', $selectedLabels);
        $this->renderPartial('/reports/attendance/ajaxLoad/viewAttendanceReportData', array('attendanceData' => $attendanceData, 'headers' => $headers, 'headersLabels' => $headersLabels, 'pageSize' => $limit, 'page' => $currentPage, 'count' => $pageCount));
    } 

}
