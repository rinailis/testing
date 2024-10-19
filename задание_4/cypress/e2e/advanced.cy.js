context("Wilddberris", () => {
  describe("Wildberries Shopping Test", () => {
    before(() => {
      cy.visit("https://test2.itroom18.ru/");

      cy.get(".header_avatar ").click();
      cy.get(".input_field").first().type("51vey@belgianairways.com");
      cy.get(".input_field").last().type("Qwe123");
      cy.get(".dialog_inner").find(".button-primary").click();

      cy.wait(2000);
    });

    it("create blog", () => {
      cy.visit("https://test2.itroom18.ru/adding/blog/");
      cy.wait(4000);
      cy.get(".adding_content-second")
        .first()
        .find(".input_field")
        .type("Тестовый блог");
      cy.get(".ce-paragraph").focus().type("Текст для блога");
      cy.get(".dropzone_window").selectFile("cypress/fixtures/images.jpg", {
        action: "drag-drop"
      });
      cy.wait(2000);
      cy.get(".dialog_inner").find(".button-primary").click();
      cy.wait(2000);
      cy.get(".button-adding-publication").click();

      cy.visit("https://test2.itroom18.ru/blogs/");
      cy.get(".blogs_card")
        .first()
        .find(".blogs_card-label")
        .should("have.text", "Тестовый блог");
    });

    it("like blog", () => {
      cy.visit("https://test2.itroom18.ru/blogs/");
      cy.get(".blogs_card").first().find(".like").click();
      cy.get(".blogs_card")
        .first()
        .find(".like")
        .should("have.class", "like-active");
      cy.reload();
      cy.get(".blogs_card")
        .first()
        .find(".like")
        .should("have.class", "like-active");
        
      cy.get(".blogs_card")
        .first()
        .find(".like")
        .should("have.css", "color")
        .and("eq", "rgb(250,255,5)");
    });

    it("collections", () => {
      cy.visit("https://test2.itroom18.ru/marketplace/russkij-drift/100/");
      cy.get(".work-details_activity-top")
        .find(".dropdown")
        .find(".dropdown")
        .click();
      cy.get(".blogs_card").find(".dropdown").find(".button-tertiary").click();

      cy.visit("https://test2.itroom18.ru/saved/");
      cy.get(".saved_works")
        .find(".card")
        .trigger("mouseover")
        .find(".card_label")
        .should("have.text", "Русский дрифт.");

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
        .should("have.text", "Русский дрифт.");
    });

    it("purchase", () => {
      cy.visit("https://test2.itroom18.ru/marketplace/russkij-drift/100/");
      cy.get(".work-details_activity-top")
        .find(".button-tertiary")
        .first()
        .click();
      cy.get(".dialog_inner").find(".button-primary").click();
      cy.wait(2000);
      cy.visit("https://test2.itroom18.ru/bought/");
      cy.get(".saved_works")
        .find(".card")
        .trigger("mouseover")
        .find(".card_label")
        .should("have.text", "Русский дрифт.");
    });

    it("search ", () => {
      cy.get(".header_search").find(".input_field").type("Русский дрифт");
      cy.get(".header_search").find(".icon ").click();
      cy.wait(2000);
      cy.get(".works_title").should(
        "have.text",
        "Поиск по запросу «Русский дрифт»"
      );

      cy.get(".works_view ").find(".card").first().click();
      cy.wait(2000);
      cy.get(".work-details_currentprice ").should("have.text", "FREE");
      cy.get(".work-details_currentprice ")
        .should("have.css", "color")
        .and("eq", "rgb(250,255,5)");
    });
  });
});
