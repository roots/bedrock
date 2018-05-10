describe('wwp-contact test suite', () => {

    it('Checks that form is working', () => {
        let host    = Cypress.env('host') || Cypress.config('host'),
            conf    = Cypress.config('wwp-contact').form,
            formUrl = conf.url;

        cy.server();
        cy.route('POST', '/contactFormSubmit').as('contactAjaxSubmit');

        cy.visit(host + formUrl);
        cy.get("#colophon").should('be.visible');
        cy.get(conf.formSelector).then(($form) => {

            let $formGroups      = $form.find('.form-group'),
                formGroupsLength = $formGroups.length;

            expect(formGroupsLength).to.be.greaterThan(0);

            console.log(formGroupsLength);

            let data = {
                "text" : "Test input",
                "textarea" : "Test Textarea",
                "email" : "test@cypress.bot"
            };

            $formGroups.each((i, elt) => {
                let $inpt = Cypress.$(elt).find('input,textarea'),
                    inputType = $inpt.attr('type') ? $inpt.attr('type') : 'textarea';
                console.log(inputType);

                if ($inpt.length > 0) {
                    cy.wrap($inpt).type(data[inputType], {force: true});
                    /*setTimeout(() => {
                        if (i === (formGroupsLength - 1)) {
                            $form.submit().as('submit');

                        }
                    }, i * 500);*/
                }
            });

        });

        cy.wait(1);
        cy.get(conf.formSelector).submit();
        cy.wait('@contactAjaxSubmit');

        // we should have visible errors now
        cy.get('.alert')
            .should('be.visible')
            .and('have.class', 'alert-success')

    });

});
