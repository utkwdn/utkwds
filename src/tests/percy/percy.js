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
  const browser = await puppeteer.launch({ headless: true,'--no-sandbox', '--disable-setuid-sandbox' });
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

  // Create an array of URIs to test
// Read URIs from uris.txt
const urisFilePath = path.resolve('uris.txt');
const uris = fs.readFileSync(urisFilePath, 'utf-8').split('\n').filter(Boolean);

  try {
    for (const uri of uris) {
      const url = `${BASE_URL}${uri}`;
      console.log(`Navigating to ${url}`);
      await page.goto(url,{waitUntil: 'networkidle0', timeout: 60000});
      await percySnapshot(page, uri);
    }
  } catch (error) {
    console.error("An error occurred while taking snapshots:", error);
  } finally {
    await browser.close();
  }

})();

