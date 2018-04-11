<?php
/* For licensing terms, see /license.txt */

use Chamilo\CoreBundle\Entity\TrackEHotspot;
use Chamilo\CourseBundle\Entity\CQuizAnswer;

/**
 * This file generates a json answer to the question preview.
 *
 * @package chamilo.exercise
 *
 * @author Toon Keppens, Julio Montoya adding hotspot "medical" support
 */
require_once __DIR__.'/../inc/global.inc.php';

api_protect_course_script();

if (!api_is_allowed_to_edit(null, true)) {
    api_not_allowed(true);
}

// Set vars
$questionId = isset($_GET['modifyAnswers']) ? (int) $_GET['modifyAnswers'] : 0;
$exerciseId = isset($_GET['exerciseId']) ? (int) $_GET['exerciseId'] : 0;
$courseId = api_get_course_int_id();

$objQuestion = Question::read($questionId, $courseId);
$objExercise = new Exercise($courseId);
$objExercise->read($exerciseId);

if (empty($objQuestion) || empty($objQuestion)) {
    exit;
}

$em = Database::getManager();
$documentPath = api_get_path(SYS_COURSE_PATH).$_course['path'].'/document';
$picturePath = $documentPath.'/images';
$pictureName = $objQuestion->getPictureFilename();
$pictureSize = getimagesize($picturePath.'/'.$pictureName);
$pictureWidth = $pictureSize[0];
$pictureHeight = $pictureSize[1];

$data = [];
$data['type'] = 'solution';
$data['lang'] = [
    'Square' => get_lang('Square'),
    'Ellipse' => get_lang('Ellipse'),
    'Polygon' => get_lang('Polygon'),
    'HotspotStatus1' => get_lang('HotspotStatus1'),
    'HotspotStatus2Polygon' => get_lang('HotspotStatus2Polygon'),
    'HotspotStatus2Other' => get_lang('HotspotStatus2Other'),
    'HotspotStatus3' => get_lang('HotspotStatus3'),
    'HotspotShowUserPoints' => get_lang('HotspotShowUserPoints'),
    'ShowHotspots' => get_lang('ShowHotspots'),
    'Triesleft' => get_lang('Triesleft'),
    'HotspotExerciseFinished' => get_lang('HotspotExerciseFinished'),
    'NextAnswer' => get_lang('NextAnswer'),
    'Delineation' => get_lang('Delineation'),
    'CloseDelineation' => get_lang('CloseDelineation'),
    'Oar' => get_lang('Oar'),
    'ClosePolygon' => get_lang('ClosePolygon'),
    'DelineationStatus1' => get_lang('DelineationStatus1'),
];
$data['image'] = $objQuestion->selectPicturePath();
$data['image_width'] = $pictureWidth;
$data['image_height'] = $pictureHeight;
$data['courseCode'] = $_course['path'];
$data['hotspots'] = [];

$showTotalScoreAndUserChoicesInLastAttempt = true;

if ($objExercise->selectResultsDisabled() == RESULT_DISABLE_SHOW_SCORE_ATTEMPT_SHOW_ANSWERS_LAST_ATTEMPT) {
    $showOnlyScore = true;
    $showResults = true;
    if ($objExercise->attempts > 0) {
        $attempts = Event::getExerciseResultsByUser(
            api_get_user_id(),
            $objExercise->id,
            api_get_course_int_id(),
            api_get_session_id(),
            $trackExerciseInfo['orig_lp_id'],
            $trackExerciseInfo['orig_lp_item_id'],
            'desc'
        );
        $numberAttempts = count($attempts);
        $showTotalScoreAndUserChoicesInLastAttempt = false;

        if ($numberAttempts >= $objExercise->attempts) {
            $showResults = true;
            $showOnlyScore = false;
            $showTotalScoreAndUserChoicesInLastAttempt = true;
        }
    }
}

$hideExpectedAnswer = false;
if ($objExercise->selectFeedbackType() == 0 && $objExercise->selectResultsDisabled() == 2) {
    $hideExpectedAnswer = true;
}

if ($objExercise->selectResultsDisabled() == RESULT_DISABLE_SHOW_SCORE_ATTEMPT_SHOW_ANSWERS_LAST_ATTEMPT) {
    $hideExpectedAnswer = $showTotalScoreAndUserChoicesInLastAttempt ? false : true;
}

if (!$hideExpectedAnswer) {
    $qb = $em->createQueryBuilder();
    $qb
        ->select('a')
        ->from('ChamiloCourseBundle:CQuizAnswer', 'a');

    if ($objQuestion->selectType() == HOT_SPOT_DELINEATION) {
        $qb
            ->where($qb->expr()->eq('a.cId', $courseId))
            ->andWhere($qb->expr()->eq('a.questionId', intval($questionId)))
            ->andWhere($qb->expr()->neq('a.hotspotType', 'noerror'))
            ->orderBy('a.id', 'ASC');
    } else {
        $qb
            ->where($qb->expr()->eq('a.cId', $courseId))
            ->andWhere($qb->expr()->eq('a.questionId', intval($questionId)))
            ->orderBy('a.position', 'ASC');
    }

    $result = $qb->getQuery()->getResult();

    /** @var CQuizAnswer $hotSpotAnswer */
    foreach ($result as $hotSpotAnswer) {
        $hotSpot = [];
        $hotSpot['id'] = $hotSpotAnswer->getIid();
        $hotSpot['answer'] = $hotSpotAnswer->getAnswer();

        switch ($hotSpotAnswer->getHotspotType()) {
            case 'square':
                $hotSpot['type'] = 'square';
                break;
            case 'circle':
                $hotSpot['type'] = 'circle';
                break;
            case 'poly':
                $hotSpot['type'] = 'poly';
                break;
            case 'delineation':
                $hotSpot['type'] = 'delineation';
                break;
            case 'oar':
                $hotSpot['type'] = 'delineation';
                break;
        }

        $hotSpot['coord'] = $hotSpotAnswer->getHotspotCoordinates();
        $data['hotspots'][] = $hotSpot;
    }
}

$data['answers'] = [];

$rs = $em
    ->getRepository('ChamiloCoreBundle:TrackEHotspot')
    ->findBy(
        [
            'hotspotQuestionId' => $questionId,
            'cId' => $courseId,
            'hotspotExeId' => $exerciseId,
        ],
        ['hotspotAnswerId' => 'ASC']
    );

/** @var TrackEHotspot $row */
foreach ($rs as $row) {
    $data['answers'][] = $row->getHotspotCoordinate();
}

$data['done'] = 'done';
header('Content-Type: application/json');

echo json_encode($data);
