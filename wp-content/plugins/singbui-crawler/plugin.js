// 'use strict'
// const API_LINK = 'http://localhost:3000';
// (async function () {
//   var stateStr = '';
//   var disabledBtn = '';

  // var states = await jQuery.get(API_LINK + '/api/klook/state');
  // if (states.success) {
  //   //state = 0 => done
  //   //state = 1 => Crawling...
  //   if (states.result[0] && states.result[0].value === "1") {
  //     stateStr = 'Crawling...';
  //     disabledBtn = 'disabled';
  //   }
  // }

  // var stateHTML = `<div 
  //   style="background:#ffab40; width:125px; text-align:center;" 
  //   id="crawl-state">
  //   <h3 style="line-height:25px" id="crawl-state-text">${stateStr}</h3>
  //   </div>
  //   <br/>`;
  // var btnHTML = `<button type="button" class="button button-primary" ${disabledBtn} id="btn-crawl">Start Crawl Klook</button>`;

  // jQuery('#crawler-main').html(stateHTML + btnHTML);

  // jQuery('#crawler-main #btn-crawl').on('click', function () {
  //   jQuery(this).attr('disabled', true);
  //   jQuery('#crawl-state').html('Crawling...');
  //   jQuery.post(API_LINK + '/api/klook/crawler');
  // });
// })();