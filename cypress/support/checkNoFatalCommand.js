export const checkNoFatalCommand = () => {
  cy.get('.xdebug-error').should('not.exist')
  cy.get("#colophon").should('exist');
}
