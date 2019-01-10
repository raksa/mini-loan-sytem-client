<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > Clients
Breadcrumbs::for('clients', function ($trail) {
    $trail->parent('home');
    $trail->push('Clients', route('clients.index'));
});

// Home > Clients > [Client]
Breadcrumbs::for('client', function ($trail, $client) {
    $trail->parent('clients');
    $trail->push('client:' . $client->client_code, route('clients.show', $client->id));
});
Breadcrumbs::for('client.create', function ($trail) {
    $trail->parent('clients');
    $trail->push('client:unknown', route('clients.create'));
});

// Home > Loans
Breadcrumbs::for('loans', function ($trail) {
    $trail->parent('home');
    $trail->push('Loans', route('loans.index'));
});

// Home > Clients > [Client] > [Loan]
Breadcrumbs::for('loan', function ($trail, $loan) {
    $trail->parent('client', $loan->client);
    $trail->push('loan:' . $loan->id, route('loans.show', $loan->id));
});
Breadcrumbs::for('loan.create', function ($trail, $client) {
    $trail->parent('client', $client);
    $trail->push('loan:unknown', route('loans.create'));
});
