context("Butter", () => {
  describe("Butter Test", () => {
    beforeEach(() => {
      cy.viewport(1920, 1000)
      cy.visit("https://test2.itroom18.ru/");

      cy.wait(2000);
      cy.get(".header_user ").click();
      cy.wait(2000);
      cy.get(".dialog_fields").find(".input_field").first().type("51vey@belgianairways.com");
      cy.get(".dialog_fields").find(".input_field").last().type("Qwe123");
      cy.get(".dialog_inner").find(".button-primary").click();

      cy.wait(2000);
    });

    it("like blog", () => {
      cy.visit("https://test2.itroom18.ru/blogs/");
      cy.wait(2000);
      cy.get(".blogs_card").first().find(".like").click();
      cy.get(".blogs_card")
        .first()
        .find(".like")
        .should("have.class", "like-active");
      cy.reload();
      cy.wait(4000);
      cy.get(".blogs_card")
        .first()
        .find(".like")
        .should("have.class", "like-active");
    });

    it("save collections", () => {
      cy.visit("https://test2.itroom18.ru/marketplace/russkij-drift/100/");
      cy.wait(2000);
      cy.get(".work-details_activity-top")
        .find(".dropdown")
        .click();
      cy.get(".work-details_activity-top")
        .find(".dropdown")
        .click();
    });
    it("collections page", () => {
      cy.visit("https://test2.itroom18.ru/saved/");
      cy.wait(2000);
      cy.get(".saved_works")
        .find(".card").first()
        .trigger("mouseover").wait(4000)
        .find(".card_label");

      const dataTransfer = new DataTransfer();
      cy.get(".saved_works")
        .find(".card")
        .first()
        .trigger("dragstart", { dataTransfer });

      cy.get(".saved_collection")
        .first()
        .trigger("drop", { dataTransfer })
        .trigger("dragend");

      cy.get(".saved_collection").first().click();
      cy.get(".saved_grid")
        .find(".card")
        .first()
        .trigger("mouseover")
        .find(".card_label")
        .should("have.text", "Рисунки фотнана");
    });

    it("search ", () => {
      cy.get(".header_search").find(".input_field").type("Русский дрифт");
      cy.get(".header_search").find(".search_actions").click();
      cy.wait(2000);
      cy.get(".works_title").should(
        "have.text",
        "Поиск по запросу «Русский дрифт»"
      );

      cy.get(".works_view ").find(".card").first().click();
      cy.wait(2000);
      cy.get(".work-details_currentprice ").should("have.text", "FREE");
    });
  });
});
