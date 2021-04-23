<?php

namespace App\Controller;

use App\Entity\PaymentRequest;
use App\Repository\PaymentRequestRepository;
use App\Service\PaymentService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{

    /**
     * @Route("/payment-index", name="payment_index")
     */
    public function index() {
        return $this->render('payment/paymentIndex.html.twig');
    }


    /**
     * @Route("/payment", name="payment")
     */
    public function payment(PaymentService $paymentService): Response
    {
        $sessionId = $paymentService->create();

        $paymentRequest = new PaymentRequest();
        $paymentRequest->setCreatedAt(new DateTime());
        $paymentRequest->setStripeSessionId($sessionId);

        $em = $this->getDoctrine()->getManager();
        $em->persist($paymentRequest);
        $em->flush();

        return $this->render('payment/payment.html.twig', [
            'sessionId' => $sessionId,
        ]);
    }

    /**
     * @Route("/payment/success/{stripeSessionId}", name="payment_success")
     */
    public function success(string $stripeSessionId, PaymentRequestRepository $paymentRequestRepository): Response
    {
        $paymentRequest = $paymentRequestRepository->findOneBy([
            'stripeSessionId' => $stripeSessionId,
        ]);

        if (!$paymentRequest) {
            return $this->redirectToRoute('payment');
        }

        $paymentRequest->setValidated(true);
        $paymentRequest->setPaidAt(new DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->render('payment/success.html.twig');
    }

    /**
     * @Route("/payment/failure/{stripeSessionId}", name="payment_failure")
     */
    public function failure(string $stripeSessionId, PaymentRequestRepository $paymentRequestRepository): Response
    {
        $paymentRequest = $paymentRequestRepository->findOneBy([
            'stripeSessionId' => $stripeSessionId,
        ]);

        if (!$paymentRequest) {
            return $this->redirectToRoute('payment');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($paymentRequest);
        $em->flush();

        return $this->render('payment/failure.html.twig');
    }

}    

