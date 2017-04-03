<?php

namespace MC\PlatformBundle\Controller;

use MC\PlatformBundle\Entity\Candidat;
use MC\PlatformBundle\Entity\Question;
use MC\PlatformBundle\Entity\Reponse;
use MC\PlatformBundle\Entity\ReponsesCandidat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class QcmController extends Controller
{
	public function indexAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$listQuestions = $em
		->getRepository('MCPlatformBundle:Question')
		->findAll()
		;

		$listReponses = $em
		->getRepository('MCPlatformBundle:Reponse')
		->findAll()
		;
		$repcorrecte = array();
		foreach ($listReponses as $reponse) {
			if ($reponse->getCorrecte() == 1) {
				array_push($repcorrecte, $reponse->getId());
			}
		}

		if ($request->request->has('submit')) {
			$result = 0;
			$reponsescandidat = array();
			foreach ($listQuestions as $question) {
				array_push($reponsescandidat, $_POST[$question->getId()]);
			}
			
			foreach ($reponsescandidat as $repscandidat) {
				if (in_array($repscandidat, $repcorrecte))
				{
					$result += 5;
				}
			}
			return $this->redirectToRoute('mc_qcm_candidat', array('result' => $result));
		}

		return $this->render('MCPlatformBundle:Qcm:qcm.html.twig', array(
			'listQuestions' => $listQuestions,
			));
	}

	public function candidatAction(Request $request, $result)
	{
		$candidat = new Candidat();

		$form = $this->get('form.factory')->createBuilder(FormType::class, $candidat)
		->add('nom',     TextType::class)
		->add('prenom',   TextType::class)
		->add('niveau',    ChoiceType::class, array('choices'  => array(
			'Licence 1' => 'L1',
			'Licence 2' => 'L2',
			'Licence 3' => 'L3',
			'Master 1' => 'M1',
			'Master 2' => 'M2'
			)))
		->add('resultat',   HiddenType::class, array('label' => 'Field', 'data' => $result))
		->add('save',      SubmitType::class)
		->getForm()
		;

		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($candidat);
				$em->flush();

				$idCandidat = $candidat->getId();
				return $this->redirectToRoute('mc_qcm_result', array('idCandidat' => $idCandidat));
			}
		}

		return $this->render('MCPlatformBundle:Qcm:candidat.html.twig', array(
			'form' => $form->createView(),
			));
	}

	public function resultAction($idCandidat)
	{
		$em = $this->getDoctrine()->getManager();
    	$candidat = $em->getRepository('MCPlatformBundle:Candidat')->find($idCandidat);

		return $this->render('MCPlatformBundle:Qcm:result.html.twig', array(
			'candidat' => $candidat,
			));
	}

	public function noteAction()
	{
		$em = $this->getDoctrine()->getManager();

		$listcandidats = $em
		->getRepository('MCPlatformBundle:Candidat')
		->findAll()
		;

		return $this->render('MCPlatformBundle:Qcm:notes.html.twig', array(
			'listcandidats' => $listcandidats,
			));
	}

	public function equipeAction()
	{
		return $this->render('MCPlatformBundle:Qcm:equipe.html.twig');
	}
}