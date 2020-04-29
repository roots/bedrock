// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
Cypress.Commands.add("wpLogin", (email, password) => {
    let host = Cypress.env('host') || Cypress.config('host'),
        conf = Cypress.config('wp-admin');
    /*cy.visit(host + conf.url);
    cy.get('#user_login').type(conf.login);
    cy.get('#user_pass').type(conf.pwd);
    cy.get('#loginform').submit();*/
    cy.request({
        method: 'POST',
        url: host+conf.url, // baseUrl is prepended to url
        form: true, // indicates the body should be form urlencoded and sets Content-Type: application/x-www-form-urlencoded headers
        body: {
            log: conf.login,
            pwd: conf.pwd
        }
    }).then((response) => {
        console.log(response);
    });
});
//
//
// -- This is a child command --
// Cypress.Commands.add("drag", { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add("dismiss", { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This is will overwrite an existing command --
// Cypress.Commands.overwrite("visit", (originalFn, url, options) => { ... })
