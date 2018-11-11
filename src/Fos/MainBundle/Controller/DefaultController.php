<?php

namespace Fos\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect('/login');
        }
        $form = $this->createForm('Fos\MainBundle\Form\Type\ListCategories');

        return $this->container->get('templating')->renderResponse(
            'FosMainBundle:Default:form_options_view.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getListCompaniesAction(Request $request)
    {
        $requestParams = $request->request->all();
        $listType = isset($requestParams['list_categories']) ? $requestParams['list_categories']['types'] : $request->query->get(
            'type'
        );
        $entityManager = $this
            ->getDoctrine()
            ->getManager();
        if (empty($listType)) {
            return $this->redirectToRoute('fos_home');
        }
        $fieldsNames = $entityManager->getClassMetadata('FosMainBundle:'.$listType)->getFieldNames();
        $listRepository = $entityManager
            ->getRepository('FosMainBundle:'.$listType)
            ->createQueryBuilder('c')
            ->getQuery();
        $result = $listRepository->getArrayResult();

        // get CA by n° siret from clas test (for test i take this const value)
        $caBySiret = '10000000';
        $percentageTaxeCompanies = '25';
        $percentageTaxeSas = '33';
        if ($listType == 'companies'){
            $tax = $this->percentageOf($caBySiret, $percentageTaxeCompanies);
        } else {
            $tax = $this->percentageOf($caBySiret, $percentageTaxeSas);
        }

        return $this->render(
            'FosMainBundle:Default:list_companies.html.twig',
            array(
                'request' => $result,
                'fields_names' => $fieldsNames,
                'list_type' => $listType,
                'tax' => $tax
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addCompanyAction(Request $request)
    {
        $type = $request->query->get('type');
        $formType = $this->getFormType($type);
        if (isset($formType)) {
            $form = $this
                ->createForm($formType)
                ->add(
                    'submit',
                    'Symfony\Component\Form\Extension\Core\Type\SubmitType',
                    array('label' => 'Ajouter l\'élèment')
                );
            $createView = $form->createView();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($data);
                $entityManager->flush();

                return $this->redirectToRoute('list_companies', array('type' => $type));
            }
        } else {
            $createView = '';
        }

        return $this->render(
            'FosMainBundle:Default:form_add_company.html.twig',
            array('form' => $createView)
        );
    }

    /**
     * @param $type
     * @return string
     */
    public function getFormType($type)
    {
        switch ($type) {
            case 'companies':
                $formType = 'Fos\MainBundle\Form\Type\CompaniesType';
                break;
            case 'sas':
                $formType = 'Fos\MainBundle\Form\Type\SasType';
                break;
            default:
                $formType = '';
        }

        return $formType;
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteCompanyAction(Request $request)
    {
        $id = $request->query->get('id');
        $type = $request->query->get('type');
        if (isset($id) and isset($type)) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository('FosMainBundle:'.$type)->find($id);
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_companies', array('type' => $type));
    }

    public function updateCompanyAction(Request $request)
    {
        $type = $request->query->get('type');
        $value = $request->query->get('value');
        $em = $this->getDoctrine()->getManager();
        $idElement = $em->getRepository('FosMainBundle:'.$type)->find($value['id']);
        $formType = $this->getFormType($type);
        $form = $this
            ->createForm($formType, $idElement)
            ->add(
                'submit',
                'Symfony\Component\Form\Extension\Core\Type\SubmitType',
                array('label' => 'Modifier  l\'élèment')
            );
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $this->redirectToRoute('list_companies', array('type' => $type));
            }
        }
        $createView = $form->createView();

        return $this->render(
            'FosMainBundle:Default:form_update_company.html.twig',
            array('form' => $createView)
        );
    }

    // function to calculate percentage
    public function percentageOf( $number, $everything, $decimals = 2 ){
        return round( $number * $everything / 100, $decimals );
    }

    function logOutAction()
    {
    }
}
