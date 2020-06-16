export const loginCommand = (email, password) => {
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
};
