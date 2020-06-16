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
import {loginCommand} from "./loginCommand";
import {checkNoFatalCommand} from "./checkNoFatalCommand";
import {checkNoFatalInAdminCommand} from "./checkNoFatalInAdminCommand";

Cypress.Commands.add("wpLogin", loginCommand);
Cypress.Commands.add("checkNoFatal", checkNoFatalCommand);
Cypress.Commands.add("checkNoFatalInAdmin", checkNoFatalInAdminCommand);
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
