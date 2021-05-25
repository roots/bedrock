export const checkNoFatalCommand = (itemSelectorToTestNoFatal) => {
  itemSelectorToTestNoFatal = itemSelectorToTestNoFatal || "#colophon";
  cy.get('.xdebug-error').should('not.exist')
  cy.get(itemSelectorToTestNoFatal).should('exist');
}
