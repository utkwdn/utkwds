/**
 * Set: PERCY_BRANCH=prd percy exec -- node snapshots.js
 * Compare: PERCY_BRANCH=dev PERCY_TARGET_BRANCH=prd percy exec -- node snapshots.js
 */

import fs from 'fs';
import path from 'path';

import puppeteer from 'puppeteer';
import percySnapshot from '@percy/puppeteer';

(async () => {
  // Create a new browser instance
  const browser = await puppeteer.launch({ headless: true,args: ['--no-sandbox', '--disable-setuid-sandbox'] });
  const page = await browser.newPage();
  await page.setViewport({ width: 1080, height: 1024 });

  const PERCY_BRANCH = process.env.PERCY_BRANCH;
  let BASE_URL = "";

  switch (PERCY_BRANCH) {
    case "prd":
      BASE_URL = "https://wds-prd.utk.edu";
      break;
    case "stg":
      BASE_URL = "https://wds-stg.utk.edu";
      break;
    case "dev":
      BASE_URL = "https://wds-dev.utk.edu";
      break;
    default:
      console.error("Please set the PERCY_BRANCH environment variable to either dev, stg, or prd");
      process.exit(1);
  }


  // Define the path to your JSON file.
  const jsonFilePath = '/var/www/html/exported_pages.json';

  // Read the JSON file asynchronously.
  fs.readFile(jsonFilePath, 'utf8', (err, data) => {
    if (err) {
      console.error(`Error reading file ${jsonFilePath}:`, err);
      return;
    }

    let jsonData;
    try {
      jsonData = JSON.parse(data);
    } catch (parseError) {
      console.error(`Error parsing JSON data from ${jsonFilePath}:`, parseError);
      return;
    }

    // Check that the JSON data is an array.
    if (!Array.isArray(jsonData)) {
      console.error('Expected JSON data to be an array.');
      return;
    }

    // Loop through each object in the array.
    jsonData.forEach(item => {
      if (item.url) {
        console.log(`Processing URL: ${item.url}`);
        // remove the protocol and hostname from the url and save in uri variable
        let uri = item.url.replace(/^https?:\/\/[^\/]+/i, '');
        //create staging url by adding https://wds-stg.utk.edu to the uri
        // let stagingUrl = 'https://wds-stg.utk.edu' + uri;
        // Replace the following line with the command you want to execute.
        // For example, if you want to make a request to the URL, you could call a function:
        // processUrl(item.url);
        try {
          const url = `${BASE_URL}${uri}`;
          console.log(`Navigating to ${url}`);
          await page.goto(url,{waitUntil: 'networkidle0', timeout: 60000});
          await percySnapshot(page, uri);    
        } catch (error) {
          console.error("An error occurred while taking snapshots:", error);
        } 
      } else {
        console.warn('No "url" property found in item:', item);
      }
    });
  });
  await browser.close();
})();