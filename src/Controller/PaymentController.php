<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\PaymentRequest;
use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\OrderRepository;
use App\Repository\PaymentRequestRepository;
use App\Repository\UserRepository;
use App\Service\PaymentService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function success(string $stripeSessionId, PaymentRequestRepository $paymentRequestRepository, OrderRepository $order): Response
    {
        $paymentRequest = $paymentRequestRepository->findOneBy([
            'stripeSessionId' => $stripeSessionId,
        ]);

        if (!$paymentRequest) {
            return $this->redirectToRoute('payment');
        }

        $paymentRequest->setValidated(true);
        $paymentRequest->setPaidAt(new DateTime());

        $order = new Order();
        $order->setPaymentRequest($paymentRequest);
        $order->addUser($this->getUser());
        $order->setPrice(1,99);
        $order->setPeriod(1);

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        $user = $this->getUser();
        $user->setRoles(["ROLE_PREMIUM"]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->persist($user);
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

//     /**
//      * @Route("/payment/cancel-subscription", name="payment_cancel")
//      */
//     public function cancel() {
//         \Stripe\Stripe::setApiKey('sk_test_51IgovzJufIouFh4tHbgJ17OG69qAxG5vFbPkVrJdPwAlesRNNiReIEy1C8han1dQV5hFq1RyOMFv41WN0XWdGKTp00PvA4P7XH');

//         $user = $this->getDoctrine()->getRepository(User::class)->findAll();
//         $user = $this->getUser();

//         $subscription = \Stripe\Subscription::retrieve($user);
//         $subscription->cancel();

//         return $this->render('payment/cancel.html.twig');
//     }
}