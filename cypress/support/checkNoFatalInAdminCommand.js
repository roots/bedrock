export const checkNoFatalInAdminCommand = () => {
  cy.get('.xdebug-error').should('not.exist')
  cy.get("#wpfooter").should('exist');
}
