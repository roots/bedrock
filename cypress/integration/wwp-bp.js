describe('wwp-bp test suite', () => {

    it('Checks that listing is working', () => {
        let host       = Cypress.env('host') || Cypress.config('host'),
            conf       = Cypress.config('wwp-bp').list,
            listingUrl = conf.url;

        cy.visit(host + listingUrl);
        cy.get("#colophon").should('be.visible');
        cy.get(conf.list.selector).should('have.class', conf.list.class);
        cy.get(conf.list.selector).children().should('have.length.above', 0);
        cy.get(conf.list.selector + ' .item:first-child').then(($item) => {
            const title = $item.find('.card-title').text();
            cy.visit($item.find('a').eq(0).attr('href'));
            cy.title().should('include', title);
        });
    });

});
