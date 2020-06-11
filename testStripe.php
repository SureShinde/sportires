<?php 

// Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('pk_live_eG8Y2pVT4o5CRwUY3N8FQOs900KQCv5sXu');

\Stripe\PaymentIntent::create([
  'amount' => 1000,
  'currency' => 'mxn',
  'payment_method_types' => ['card'],
  'receipt_email' => 'jenny.rosen@example.com',
]);
?>
