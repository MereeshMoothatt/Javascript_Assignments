"use strict";

//initialize global variables
const cardBlank = "images/blank.png";
const cardBack = "images/back.png";
var first = "";
var second = "";
var isFirstImageClick = true;
var num_cards;
var initial_screen = "settings";
var cards = [];
var images = [];
const total_cards = 24;
var totalClicks = 0;
var correct = 0;
var attempts;
var yourScore = 0;

$(document).ready(() => {

  // getting player name from session storage
  if (sessionStorage.getItem("player_name") !== null) {
    $("#playerName").text(
      "Player Name : " + sessionStorage.getItem("player_name")
    );
    initial_screen = "play_game";
  }

  // getting high score from local storage
  if (localStorage.getItem("high_score") !== null) {
    $("#highScore").text(localStorage.getItem("high_score"));
  }
  // getting card numbers from session storage or default 48
  if (sessionStorage.getItem("num_cards") === null) {
    num_cards = 48;
  } else {
    num_cards = sessionStorage.getItem("num_cards");
  }

  //On page load user interface is loaded.
  loadUserInterface(initial_screen);

  //When user clicks on save_settings button, save the settings details
  saveSettings();

  //Preload images
  preloadImages(images, cards);

  //load random images and cardDeck is the collection of card ids and cardDeck is the collection of card ids
  loadCardDeck(num_cards, cards);

  // when user click on cards till the game ends
  clickOnCards();

}); // end ready


function loadUserInterface(initial_screen) {
  if (initial_screen === "play_game") {
    $("#play_game_tab").css("display", "block");
    $("#view_rules_tab").css("display", "none");
    $("#settings_tab").css("display", "none");
    selectedLinkColor("#play_game_link");
  } else {
    $("#play_game_tab").css("display", "none");
    $("#view_rules_tab").css("display", "none");
    $("#settings_tab").css("display", "block");
    selectedLinkColor("#settings_link");
  }

  //On click of Play Game
  $("#play_game_link").click(() => {
    selectedLinkColor("#play_game_link");
    setOtherLinkColor("#view_rules_link");
    setOtherLinkColor("#settings_link");
    $("#play_game_tab").css("display", "block");
    $("#view_rules_tab").css("display", "none");
    $("#settings_tab").css("display", "none");
  });

  //On click of View Rules
  $("#view_rules_link").click(() => {
    selectedLinkColor("#view_rules_link");
    setOtherLinkColor("#play_game_link");
    setOtherLinkColor("#settings_link");
    $("#play_game_tab").css("display", "none");
    $("#view_rules_tab").css("display", "block");
    $("#settings_tab").css("display", "none");
  });

  //On click of Settings
  $("#settings_link").click(() => {
    selectedLinkColor("#settings_link");
    setOtherLinkColor("#play_game_link");
    setOtherLinkColor("#view_rules_link");

    $("#play_game_tab").css("display", "none");
    $("#view_rules_tab").css("display", "none");
    $("#settings_tab").css("display", "block");
  });
}

function selectedLinkColor(link_id) {
  $(link_id).css("color", "white");
  $(link_id).css("backgroundColor", "blue");
}

function setOtherLinkColor(link_id) {
  $(link_id).css("color", "black");
  $(link_id).css("backgroundColor", "white");
}

function saveSettings() {
  $("#save_settings").click(event => {
    const player_name = $("#player_name").val().trim();
    var card_numbers = document.getElementById("num_cards");
    var num_cards = card_numbers.options[card_numbers.selectedIndex].text;

    if (player_name == ""
      && (sessionStorage.getItem("player_name") === null || sessionStorage.getItem("player_name") === "")) {
      $("#player_name").next().text("Player name is required.");
    } else {
      if (player_name !== "") {
        sessionStorage.setItem("player_name", player_name);
      }
      sessionStorage.setItem("num_cards", num_cards);
      location.reload();
    }
  });
}

function preloadImages(images, cards) {
  for (let counter = 1; counter <= total_cards; counter++) {
    const image = new Image();
    var card_url = "images/card_" + counter + ".png";
    image.src = card_url;
    images.push(image);
    cards.push(card_url);
  }
  // console.log("Cards Array : "+ cards);
}

function loadCardDeck(num_cards, cards) {
  //shuffle the total cards which is preloaded
  var totalShuffledCards = shuffleTotalCards(cards);

  // create a shuffled card deck based on the number of cards that user want to play
  var cardDeck = createCardDeck(num_cards, totalShuffledCards);

  //drawing the card deck based on the number of cards and the created card deck
  drawCardDeck(num_cards, cardDeck);
  return cardDeck;
}

function drawCardDeck(num_cards, cardDeck) {
  var rows = num_cards / 8;
  var index = 0;
  var initial_image_id = "images/back.png";
  for (let row_counter = 1; row_counter <= rows; row_counter++) {
    const divId = "cards_row" + row_counter;
    const new_div = $("<div/>")
      .attr("id", divId)
      .css("padding", "0%")
      .appendTo("#cards");
    for (let column = 1; column <= 8; column++) {
      const li = $("<li/>").css("display", "inline").appendTo(new_div);
      var link_id = cardDeck[index];
      const a = $("<a/>").attr("href", "#").attr("id", link_id).appendTo(li);
      const img = $("<img/>")
        .attr("src", initial_image_id)
        .attr("alt", "")
        .appendTo(a);
      index++;
    }
  }
}
function shuffleTotalCards(cards) {
  var currentIndex = cards.length;
  var randomIndex;
  while (currentIndex != 0) {
    // Pick a remaining element.
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;
    // Swap it with the current element.
    [cards[currentIndex], cards[randomIndex]] = [
      cards[randomIndex],
      cards[currentIndex],
    ];
  }
  return cards;
}
function createCardDeck(num_cards, totalShuffledCards) {
  var totalPairs = num_cards / 2;
  var totalPlayingCards = [];
  for (let counter = 0; counter < totalPairs; counter++) {
    totalPlayingCards[counter] = totalShuffledCards[counter];
  }
  var copiedPlayingCards = totalPlayingCards.slice();
  var counter = totalPairs;
  for (let card of copiedPlayingCards) {
    totalPlayingCards[counter] = card;
    counter++;
  }
  return shuffleTotalCards(totalPlayingCards);
}

function clickOnCards() {
  $(document).on("click", "a", function () {
    if (!($(this).hasClass("clicked"))) {
      totalClicks++;
      let link = $(this);
      // add a class 'clicked' for the clicked link and this helps hide images
      link.attr("class", "clicked");
      if (isFirstImageClick == true) {
        first = link;
        openCard(first);
        isFirstImageClick = false;
      } else {
        $('a').prop('disabled', true);
          second = link;
          openCard(second);
          //reset first image click to true as all cards are turned back.
          isFirstImageClick = true;
          //number of attempts
          attempts = totalClicks / 2;
          //when both cards are same
          setTimeout(() => {
          if (first.attr("id") === second.attr("id")) {
            correct++;
            var cardTypeId = cardBlank;
          } else {
            var cardTypeId = cardBack;
          }
          turnDownCards(first, second, cardTypeId);
          calculateScore();
          $('a').prop('disabled', false);
          }, 1000);
      }
    }
  });
}

function calculateScore() {
  yourScore = Math.round(correct / attempts * 100);
  $("#yourScore").text(yourScore);
  if (correct === (num_cards) / 2) {
    setHighScore(yourScore);
    finishMessage(yourScore);
  }
}

function finishMessage(yourScore) {
  var finish = "Game Over! Your total score : " + yourScore;
  const divId = "game_over";
  const new_div = $("<div/>")
    .attr("id", divId)
    .css("padding", "5%")
    .prependTo("#cards");
  const h3 = $("<h3/>").css("display", "inline").text(finish).appendTo(new_div);
}

function turnDownCards(first, second, cardTypeId) {
  fadeOutImage(first);
  fadeOutImage(second);
  if (cardTypeId === cardBack) {
    first.removeAttr("class");
    second.removeAttr("class");
  }
  setTimeout(() => fadeInBothCardBack(second, first, cardTypeId), 500);
}

function fadeInBothCardBack(second, first, cardTypeId) {
  second.find("img").attr("src", cardTypeId).fadeIn(500);
  first.find("img").attr("src", cardTypeId).fadeIn(500);
}

function openCard(first) {
  fadeOutImage(first);
  setTimeout(() => fadeInImage(first), 500);
}

function fadeOutImage(link) {
  link.find("img").fadeOut(500);
}

function fadeInImage(link) {
  link.find("img").attr("src", link.attr("id")).fadeIn(500);
}

function setHighScore(yourScore) {
  if (yourScore > localStorage.getItem("high_score")) {
    localStorage.setItem("high_score", $("#yourScore").text());
    $("#highScore").text($("#yourScore").text());
  }
}

