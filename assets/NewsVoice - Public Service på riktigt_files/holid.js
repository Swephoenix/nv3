/* 2025-02-27 03:02 - Uncompressed version ..... */

if (typeof holid_keyvalues === 'undefined') {
  var holid_keyvalues = [];
};

 if(typeof holidScriptsPreLoad === 'undefined' || holidScriptsPreLoad != true){document.body.appendChild(document.createElement("script")).src = "https://securepubads.g.doubleclick.net/tag/js/gpt.js";}

/* Google tagmanager, part 2 */
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
googletag.cmd.push(function() {
    googletag.pubads().disableInitialLoad();
});

/* CMP Geo Location */
var holid_cmp_status = "wait"; // wait, full_tcf_gpp, full_gpp, not_needed, error

const tcf_gpp_CountriesRequiringCMP = [
    "AT", "BE", "BG", "HR", "CY", "CZ", "DK", "EE", "FI", "FR",
    "DE", "GR", "HU", "IE", "IT", "LV", "LT", "LU", "MT", "NL",
    "PL", "PT", "RO", "SK", "SI", "ES", "SE", "GB", "IS", "LI", 
    "NO", "CH", "CA", "BR"
];

const gpp_CountriesRequiringCMP = [
    "US"
];
function checkCountryAndPerformAction() {
    const storedStatus = localStorage.getItem('holid_cmp_status');
    if (storedStatus) {
        if(storedStatus === "full" || storedStatus === "none"){
             localStorage.removeItem("holid_cmp_status");
        } else {
             holid_cmp_status = storedStatus;
             return;
        }
    }

    fetch('https://ip.holid.io/')
        .then(response => response.text())
        .then(countryCode => {
            if (tcf_gpp_CountriesRequiringCMP.includes(countryCode)) {
                holid_cmp_status = "full_tcf_gpp";
            } else if (gpp_CountriesRequiringCMP.includes(countryCode)) {
                holid_cmp_status = "full_gpp";
            }
            else {
                holid_cmp_status = "not_needed";
            }
            localStorage.setItem('holid_cmp_status', holid_cmp_status);
        })
        .catch(error => {
            holid_cmp_status = "error";
        });
}

function waitForStatusChange() {
    const maxWaitTime = 2000; // Max wait (2 sekunder)
    const checkInterval = 100; // Hur ofta vi kontrollerar (varje 100 ms)

    const intervalId = setInterval(() => {
        if (holid_cmp_status !== "wait") {
            clearInterval(intervalId);
            if (holid_cmp_status === "full_tcf_gpp" || holid_cmp_status === "full_gpp") {
                showCMP(holid_cmp_status);
            }  else {
                holid_init();
            }
        }
    }, checkInterval);

    setTimeout(() => {
        clearInterval(intervalId);
        if (holid_cmp_status === "wait") {
            holid_cmp_status = "error";
            console.error("Timeout: No response within 2 seconds. CMP initiated.");
            holid_init();
        }
    }, maxWaitTime);
}
 
function showCMP(holid_cmp_status) {
    function ensureTcfApiIsAvailable(callback, attemptsLeft = 30) {
        if (typeof window.__tcfapi === 'function') {
            callback(); // __tcfapi ÃƒÂ¤r tillgÃƒÂ¤nglig
        } else if (attemptsLeft > 0) {
            setTimeout(() => ensureTcfApiIsAvailable(callback, attemptsLeft - 1), 100);
        } else {
            console.error('__tcfapi is not defined after waiting.');
        }
    }

    
                if (typeof window.__tcfapi !== 'function') {
                        setTimeout(() => {
                            console.log('CMP Fail: Waited 2 extra seconds for external CMP. Now running internal version.');
                            if (typeof window.__tcfapi !== 'function') {
                            (function() {
  var host = window.location.hostname;
  var element = document.createElement('script');
  var firstScript = document.getElementsByTagName('script')[0];
  var url = 'https://cmp.inmobi.com'
    .concat('/choice/', 'cs41rqMUk0h46', '/', host, '/choice.js?tag_version=V3');
  var uspTries = 0;
  var uspTriesLimit = 3;
  element.async = true;
  element.type = 'text/javascript';
  element.src = url;

  firstScript.parentNode.insertBefore(element, firstScript);

  function makeStub() {
    var TCF_LOCATOR_NAME = '__tcfapiLocator';
    var queue = [];
    var win = window;
    var cmpFrame;

    function addFrame() {
      var doc = win.document;
      var otherCMP = !!(win.frames[TCF_LOCATOR_NAME]);

      if (!otherCMP) {
        if (doc.body) {
          var iframe = doc.createElement('iframe');

          iframe.style.cssText = 'display:none';
          iframe.name = TCF_LOCATOR_NAME;
          doc.body.appendChild(iframe);
        } else {
          setTimeout(addFrame, 5);
        }
      }
      return !otherCMP;
    }

    function tcfAPIHandler() {
      var gdprApplies;
      var args = arguments;

      if (!args.length) {
        return queue;
      } else if (args[0] === 'setGdprApplies') {
        if (
          args.length > 3 &&
          args[2] === 2 &&
          typeof args[3] === 'boolean'
        ) {
          gdprApplies = args[3];
          if (typeof args[2] === 'function') {
            args[2]('set', true);
          }
        }
      } else if (args[0] === 'ping') {
        var retr = {
          gdprApplies: gdprApplies,
          cmpLoaded: false,
          cmpStatus: 'stub'
        };

        if (typeof args[2] === 'function') {
          args[2](retr);
        }
      } else {
        if(args[0] === 'init' && typeof args[3] === 'object') {
          args[3] = Object.assign(args[3], { tag_version: 'V3' });
        }
        queue.push(args);
      }
    }

    function postMessageEventHandler(event) {
      var msgIsString = typeof event.data === 'string';
      var json = {};

      try {
        if (msgIsString) {
          json = JSON.parse(event.data);
        } else {
          json = event.data;
        }
      } catch (ignore) {}

      var payload = json.__tcfapiCall;

      if (payload) {
        window.__tcfapi(
          payload.command,
          payload.version,
          function(retValue, success) {
            var returnMsg = {
              __tcfapiReturn: {
                returnValue: retValue,
                success: success,
                callId: payload.callId
              }
            };
            if (msgIsString) {
              returnMsg = JSON.stringify(returnMsg);
            }
            if (event && event.source && event.source.postMessage) {
              event.source.postMessage(returnMsg, '*');
            }
          },
          payload.parameter
        );
      }
    }

    while (win) {
      try {
        if (win.frames[TCF_LOCATOR_NAME]) {
          cmpFrame = win;
          break;
        }
      } catch (ignore) {}

      if (win === window.top) {
        break;
      }
      win = win.parent;
    }
    if (!cmpFrame) {
      addFrame();
      win.__tcfapi = tcfAPIHandler;
      win.addEventListener('message', postMessageEventHandler, false);
    }
  };

  makeStub();

  function makeGppStub() {
    const CMP_ID = 10;
    const SUPPORTED_APIS = [
      '2:tcfeuv2',
      '6:uspv1',
      '7:usnatv1',
      '8:usca',
      '9:usvav1',
      '10:uscov1',
      '11:usutv1',
      '12:usctv1'
    ];

    window.__gpp_addFrame = function (n) {
      if (!window.frames[n]) {
        if (document.body) {
          var i = document.createElement("iframe");
          i.style.cssText = "display:none";
          i.name = n;
          document.body.appendChild(i);
        } else {
          window.setTimeout(window.__gpp_addFrame, 10, n);
        }
      }
    };
    window.__gpp_stub = function () {
      var b = arguments;
      __gpp.queue = __gpp.queue || [];
      __gpp.events = __gpp.events || [];

      if (!b.length || (b.length == 1 && b[0] == "queue")) {
        return __gpp.queue;
      }

      if (b.length == 1 && b[0] == "events") {
        return __gpp.events;
      }

      var cmd = b[0];
      var clb = b.length > 1 ? b[1] : null;
      var par = b.length > 2 ? b[2] : null;
      if (cmd === "ping") {
        clb(
          {
            gppVersion: "1.1", // must be "Version.Subversion", current: "1.1"
            cmpStatus: "stub", // possible values: stub, loading, loaded, error
            cmpDisplayStatus: "hidden", // possible values: hidden, visible, disabled
            signalStatus: "not ready", // possible values: not ready, ready
            supportedAPIs: SUPPORTED_APIS, // list of supported APIs
            cmpId: CMP_ID, // IAB assigned CMP ID, may be 0 during stub/loading
            sectionList: [],
            applicableSections: [-1],
            gppString: "",
            parsedSections: {},
          },
          true
        );
      } else if (cmd === "addEventListener") {
        if (!("lastId" in __gpp)) {
          __gpp.lastId = 0;
        }
        __gpp.lastId++;
        var lnr = __gpp.lastId;
        __gpp.events.push({
          id: lnr,
          callback: clb,
          parameter: par,
        });
        clb(
          {
            eventName: "listenerRegistered",
            listenerId: lnr, // Registered ID of the listener
            data: true, // positive signal
            pingData: {
              gppVersion: "1.1", // must be "Version.Subversion", current: "1.1"
              cmpStatus: "stub", // possible values: stub, loading, loaded, error
              cmpDisplayStatus: "hidden", // possible values: hidden, visible, disabled
              signalStatus: "not ready", // possible values: not ready, ready
              supportedAPIs: SUPPORTED_APIS, // list of supported APIs
              cmpId: CMP_ID, // list of supported APIs
              sectionList: [],
              applicableSections: [-1],
              gppString: "",
              parsedSections: {},
            },
          },
          true
        );
      } else if (cmd === "removeEventListener") {
        var success = false;
        for (var i = 0; i < __gpp.events.length; i++) {
          if (__gpp.events[i].id == par) {
            __gpp.events.splice(i, 1);
            success = true;
            break;
          }
        }
        clb(
          {
            eventName: "listenerRemoved",
            listenerId: par, // Registered ID of the listener
            data: success, // status info
            pingData: {
              gppVersion: "1.1", // must be "Version.Subversion", current: "1.1"
              cmpStatus: "stub", // possible values: stub, loading, loaded, error
              cmpDisplayStatus: "hidden", // possible values: hidden, visible, disabled
              signalStatus: "not ready", // possible values: not ready, ready
              supportedAPIs: SUPPORTED_APIS, // list of supported APIs
              cmpId: CMP_ID, // CMP ID
              sectionList: [],
              applicableSections: [-1],
              gppString: "",
              parsedSections: {},
            },
          },
          true
        );
      } else if (cmd === "hasSection") {
        clb(false, true);
      } else if (cmd === "getSection" || cmd === "getField") {
        clb(null, true);
      }
      //queue all other commands
      else {
        __gpp.queue.push([].slice.apply(b));
      }
    };
    window.__gpp_msghandler = function (event) {
      var msgIsString = typeof event.data === "string";
      try {
        var json = msgIsString ? JSON.parse(event.data) : event.data;
      } catch (e) {
        var json = null;
      }
      if (typeof json === "object" && json !== null && "__gppCall" in json) {
        var i = json.__gppCall;
        window.__gpp(
          i.command,
          function (retValue, success) {
            var returnMsg = {
              __gppReturn: {
                returnValue: retValue,
                success: success,
                callId: i.callId,
              },
            };
            event.source.postMessage(msgIsString ? JSON.stringify(returnMsg) : returnMsg, "*");
          },
          "parameter" in i ? i.parameter : null,
          "version" in i ? i.version : "1.1"
        );
      }
    };
    if (!("__gpp" in window) || typeof window.__gpp !== "function") {
      window.__gpp = window.__gpp_stub;
      window.addEventListener("message", window.__gpp_msghandler, false);
      window.__gpp_addFrame("__gppLocator");
    }
  };

  makeGppStub();

  var uspStubFunction = function() {
    var arg = arguments;
    if (typeof window.__uspapi !== uspStubFunction) {
      setTimeout(function() {
        if (typeof window.__uspapi !== 'undefined') {
          window.__uspapi.apply(window.__uspapi, arg);
        }
      }, 500);
    }
  };

  var checkIfUspIsReady = function() {
    uspTries++;
    if (window.__uspapi === uspStubFunction && uspTries < uspTriesLimit) {
      console.warn('USP is not accessible');
    } else {
      clearInterval(uspInterval);
    }
  };

  if (typeof window.__uspapi === 'undefined') {
    window.__uspapi = uspStubFunction;
    var uspInterval = setInterval(checkIfUspIsReady, 6000);
  }
})();
                            }
                        }, 2000);
                    }
                

if (holid_cmp_status === "full_tcf_gpp") {
    ensureTcfApiIsAvailable(() => {
        window.__tcfapi('addEventListener', 2, function(tcData, success) {
            if (success && tcData.gdprApplies) {
                if (tcData.eventStatus === 'tcloaded' || tcData.eventStatus === 'useractioncomplete') {
                    if (typeof holidCustomInit === 'undefined' || !holidCustomInit) {
                        holid_init();
                    }
                } else {
                    holidDebugLog('Consent not given, refresh loaded.');
                }
            }
        });
        })
};
    
    
if (holid_cmp_status === "full_gpp") {
    function waitForValidGppString(callback) {
        __gpp("ping", function (pingData, success) {
            if (success && pingData.gppString !== "DBAA") {
                callback();
            } else {
                setTimeout(() => waitForValidGppString(callback), 100);
            }
        });
    }

    function checkConsentAndInitializeAds(pingData) {
        if (pingData.signalStatus === "ready" && pingData.cmpDisplayStatus === "hidden") {
            if (pingData.gppString !== "DBAA") {
                holid_init();
            } else {
                waitForValidGppString(holid_init);
            }
        }
    }

    function onCmpEvent(eventData, success) {
        if (success && eventData.eventName === "signalStatus" && eventData.data === "ready") {
            checkConsentAndInitializeAds(eventData.pingData);
        }
    }

    if (typeof __gpp !== "undefined") {
        __gpp("addEventListener", onCmpEvent);
        __gpp("ping", function (pingData, success) {
            if (success) {
                checkConsentAndInitializeAds(pingData);
            }
        });
    }
}

}


checkCountryAndPerformAction();

document.body.appendChild(document.createElement("script")).src = 'https://ads.holid.io/prebid.9.19.gdpr.meta.highestbid.js';
//document.body.appendChild(document.createElement("script")).src = 'https://ads.holid.io/prebid9.26.0_new.js';


var adUnits_found = [];
var holid_version = "V4.1 - Dynamic CMP";
var is_active_amazon_uam = false;

var PREBID_TIMEOUT = 900;
var holidSiteId = 21756427176;



var adUnits_holid = [
// UPDATE //
//Newsvoice.se_pano_LSMB_Pano1
    {
        code: 'div-gpt-ad-3584348-1',
        holidTag: 'Newsvoice.se_pano_LSMB_Pano1',
        role:'widescreen',
        mediaTypes: {
            banner: {
		sizes: [ [980, 240], [980, 300], [970, 120], [728, 90] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920296'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931293',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698531'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931319',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434275'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403834',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_pano_LSMB_Pano2
    {
        code: 'div-gpt-ad-3584348-2',
        holidTag: 'Newsvoice.se_pano_LSMB_Pano2',
        role:'widescreen',
        mediaTypes: {
            banner: {
		sizes: [ [980, 240], [980, 300], [970, 120], [728, 90] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920298'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931294',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698532'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931320',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434275'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403835',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_pano_LSMB_Pano3
    {
        code: 'div-gpt-ad-3584348-3',
        holidTag: 'Newsvoice.se_pano_LSMB_Pano3',
        role:'custom0',
        mediaTypes: {
            banner: {
		sizes: [ [728, 90] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920300'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931295',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698535'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931321',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434275'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403836',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_MPU_ML_Box1
    {
        code: 'div-gpt-ad-3584348-4',
        holidTag: 'Newsvoice.se_MPU_ML_Box1',
        role:'box',
        mediaTypes: {
            banner: {
		sizes: [ [300, 250], [250, 250] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920302'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931296',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698536'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931322',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403837',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_MPU_ML_Box2
    {
        code: 'div-gpt-ad-3584348-5',
        holidTag: 'Newsvoice.se_MPU_ML_Box2',
        role:'box',
        mediaTypes: {
            banner: {
		sizes: [ [300, 250], [250, 250] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920304'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931297',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698537'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931323',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403838',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_MPU_ML_Box3
    {
        code: 'div-gpt-ad-3584348-6',
        holidTag: 'Newsvoice.se_MPU_ML_Box3',
        role:'box',
        mediaTypes: {
            banner: {
		sizes: [ [300, 250], [250, 250] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920306'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931298',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698538'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931324',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403839',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_TWS_SBZ_Tower1
    {
        code: 'div-gpt-ad-3584348-7',
        holidTag: 'Newsvoice.se_TWS_SBZ_Tower1',
        role:'tower',
        mediaTypes: {
            banner: {
		sizes: [ [300, 250], [160, 600], [300, 600] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920308'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931299',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698539'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931325',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403840',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_TWS_SBZ_Tower2
    {
        code: 'div-gpt-ad-3584348-8',
        holidTag: 'Newsvoice.se_TWS_SBZ_Tower2',
        role:'tower',
        mediaTypes: {
            banner: {
		sizes: [ [300, 250], [160, 600], [300, 600] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920310'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931300',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698541'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931326',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403841',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_TWS_SBZ_Tower3
    {
        code: 'div-gpt-ad-3584348-9',
        holidTag: 'Newsvoice.se_TWS_SBZ_Tower3',
        role:'tower',
        mediaTypes: {
            banner: {
		sizes: [ [300, 250], [160, 600], [300, 600] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920312'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931301',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698542'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931327',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403842',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_Mob_LSMB_Mob1
    {
        code: 'div-gpt-ad-3584348-10',
        holidTag: 'Newsvoice.se_Mob_LSMB_Mob1',
        role:'mobile',
        mediaTypes: {
            banner: {
		sizes: [ [320, 320], [300, 250], [320, 160], [320, 50] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920314'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931302',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698544'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931328',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403843',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_Mob_LSMB_Mob2
    {
        code: 'div-gpt-ad-3584348-11',
        holidTag: 'Newsvoice.se_Mob_LSMB_Mob2',
        role:'mobile',
        mediaTypes: {
            banner: {
		sizes: [ [320, 320], [300, 250], [320, 160], [320, 50] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920316'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931303',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698545'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931329',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403844',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_Mob_LSMB_Mob3
    {
        code: 'div-gpt-ad-3584348-12',
        holidTag: 'Newsvoice.se_Mob_LSMB_Mob3',
        role:'mobile',
        mediaTypes: {
            banner: {
		sizes: [ [320, 320], [300, 250], [320, 160], [320, 50] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920318'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931304',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698546'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931330',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403845',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_Mob_LSMB_Mob4
    {
        code: 'div-gpt-ad-3584348-13',
        holidTag: 'Newsvoice.se_Mob_LSMB_Mob4',
        role:'mobile',
        mediaTypes: {
            banner: {
		sizes: [ [320, 320], [300, 250], [320, 160], [320, 50] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920334'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931305',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698548'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931331',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403846',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
    },

//Newsvoice.se_Mob_LSMB_Mob5
    {
        code: 'div-gpt-ad-3584348-14',
        holidTag: 'Newsvoice.se_Mob_LSMB_Mob5',
        role:'mobile',
        mediaTypes: {
            banner: {
		sizes: [ [320, 320], [300, 250], [320, 160], [320, 50] ]           
            }
        },
        bids: [
            {
                bidder: 'rubicon',
                params: {
                    accountId: '19172',
                    siteId: '357386',
                    zoneId: '1920336'
                }
            },{
                bidder: 'adform',
                params: {
                    mid: '931306',
                    rcur: 'USD'
                }
            },{
                bidder: 'appnexus',
                params: {
                    placementId: '20698550'
                }
            },{
                    bidder: 'openrtb',
                    params: {
                      mid: '931332',
                      rcur: 'USD'
                }
               },{
                bidder: 'criteo',
                params: {
                    zoneId: '1434266'
                }
            },{
                bidder: 'improvedigital',
                params: {
                    placementId: '22403847',
                    keyValues: {
                        hb : ["true"]
                    }
                }
            }
        ]
   }];


// var type = "";
var adUnits_holid = adUnits_holid || [];
var adUnits_holid_org = adUnits_holid || [];
var holid_div_ids = [];
var adUnits_inUse = [];
var bannerOverride = bannerOverride || [];
var refresh_interval;
var refresh_num = 0;
var holid_refresh_max = 10;
var refresh_height = false;
var interval;
var interval_check_time_in_view;
var interval_init; /* Used for single page applications */
let divs_in_view = [];
let divs_ready_for_refresh = [];
var slots = [];
var holid_interval_find_empty_divs;
var holid_interval_timer;
var holid_interval_timer_reuse;
var holid_time_minimum_time_in_view = 6; // Minimum time in view to accept refresh.
var holid_time_extra_for_refreshed_banners = 19; // Add extra time for refreshed banners in view next time it refresh. For example if there is a normal timelimit of 10 seconds for the first refresh, the second will be longer
var holid_time_check = 0.3; // How often look for banners in view
var holid_time_minimum_before_refresh = 20; // This is the minimum time limit needed before any refresh is accepted at all. If set to 30, no refresh is acceptable before 30 seconds since last refresh was made.
var holid_interval_counter = 0;
var holid_time_max_before_refreshed_banners_in_view = 45;
var div_ads = [];
var acceptedFormats = ["bottom", "top", "cube", "tower", "widescreen", "box", "mobile", "tablet", "native", "video", "topscroll", "midscroll", "skins", "fullpage"];
var windowWidth = window.outerWidth;
var matches = document.querySelectorAll('.holidAds,.holidads');
var customs = [];
var len;
var customName = "";
var usedIds = [];

(function() {
    // Hämta URL parametern
    const urlParams = new URLSearchParams(window.location.search);
    const debugMode = urlParams.has('holid_debug') && urlParams.get('holid_debug') === '1';

    // Skapa en egen loggningsfunktion
    window.holidDebugLog = function(...args) {
        if (debugMode) {
            console.log.apply(console, args);
        }
    };
})();

for (var x = 0; x < 100; x++){
    customName = "custom"+x;
    customs.push(customName);
    acceptedFormats.push(customName);
}

if(windowWidth<728) {
    for (let i = 0; i < matches.length; i++) {
        matches[i].classList.replace("widescreen","mobile");
        matches[i].classList.replace("box","mobile");
    }
}


if(windowWidth < 1024){
    var ad_sizes= {
        "widescreen": [ [728, 90], [980, 300], [970, 250], [980, 120],[970, 90], [980, 250],[980, 150], [980, 240], [970, 120], [980, 600], [980, 480]],
        "box": [ [300, 250], [300, 300], [320, 250], [250, 250],[250, 360], [336, 280]],
        "tower": [ [300, 250], [300, 300], [320, 250], [250, 250],[250, 360]],
        "mobile": [ [300, 250],[320, 320],[320, 480], [320, 50], [250, 360], [300, 50], [300, 300],[250, 250]],
        "universal": [[300, 250], [320, 320], [728, 90], [320, 50], [468, 60], [980, 300], [970, 250], [980, 120], [970, 90], [300, 300], [320, 250], [250, 250], [980, 250], [250, 360], [336, 280], [300, 50], [980, 150], [980, 240], [970, 120], [980, 600], [980, 480],[980, 400], [320, 480]],
        "native": [ [1,1]],
        "video": [ [1,1]],
        "topscroll": [ [1,1]],
        "midscroll": [ [1,1]],
        "skins": [ [1,1]],
        "fullpage": [ [1,1]]
    };
} else {
    var ad_sizes= {
        "widescreen": [ [728, 90], [980, 300], [970, 250], [980, 120],[970, 90], [980, 250],[980, 150], [980, 240], [970, 120], [980, 600], [980, 480]],
        "box": [ [300, 250], [300, 300], [320, 250], [250, 250],[250, 360], [336, 280]],
        "tower": [ [300, 250], [300, 600],[160, 600], [120, 600], [300, 300], [320, 250], [250, 250],[250, 360]],
        "mobile": [ [300, 250],[320, 320],[320, 480], [320, 50], [250, 360], [300, 50], [300, 300],[250, 250]],
        "universal": [[300, 250], [320, 320], [728, 90], [320, 50], [468, 60], [980, 300], [970, 250], [980, 120], [970, 90], [300, 300], [320, 250], [250, 250], [980, 250], [250, 360], [336, 280], [300, 50], [980, 150], [980, 240], [970, 120], [980, 600], [980, 480],[980, 400],[320, 480]],
        "native": [ [1,1]],
        "video": [ [1,1]],
        "topscroll": [ [1,1]],
        "midscroll": [ [1,1]],
        "skins": [ [1,1]],
        "fullpage": [ [1,1]]
    };
}


function updateAdUnits(adUnits, adSizes) {


    for (let adUnit of adUnits) {
        let updatedSizes = [];

        if (adUnit.mediaTypes && adUnit.mediaTypes.banner && adUnit.mediaTypes.banner.sizes) {
            // Iterera genom nuvarande storlekar och uppdatera om nödvändigt
            for (let size of adUnit.mediaTypes.banner.sizes) {
                // Kontrollera direkt här om storleken redan finns
                if (!updatedSizes.some(existingSize => existingSize[0] === size[0] && existingSize[1] === size[1])) {
                    updatedSizes.push(size);
                }
            }

            // Lägg till universella storlekar om 'role' är undefined
            if (typeof adUnit.role === "undefined" && adSizes.universal) {
                for (let universalSize of adSizes.universal) {
                    if (!updatedSizes.some(existingSize => existingSize[0] === universalSize[0] && existingSize[1] === universalSize[1])) {
                        updatedSizes.push(universalSize);
                    }
                }
            }

            // Specialfall: Lägg till universella storlekar för storlekar [2, 2]
            adUnit.mediaTypes.banner.sizes.forEach(size => {
                if (size[0] === 2 && size[1] === 2 && adSizes.universal) {
                    adSizes.universal.forEach(universalSize => {
                        if (!updatedSizes.some(existingSize => existingSize[0] === universalSize[0] && existingSize[1] === universalSize[1])) {
                            updatedSizes.push(universalSize);
                        }
                    });
                }
            });

            // Hantera storlekar baserat på 'role'
            if (adUnit.role && adSizes[adUnit.role]) {
                for (let roleSize of adSizes[adUnit.role]) {
                    if (!updatedSizes.some(existingSize => existingSize[0] === roleSize[0] && existingSize[1] === roleSize[1])) {
                        updatedSizes.push(roleSize);
                    }
                }
            }

            // Tilldela de uppdaterade storlekarna tillbaka till adUnit
            adUnit.mediaTypes.banner.sizes = updatedSizes;
        } else {
            adUnit.mediaTypes = {
                banner: {
                    sizes: adSizes.universal ? adSizes.universal.slice() : []
                }
            };

            if (adUnit.role && adSizes[adUnit.role]) {
                for (let roleSize of adSizes[adUnit.role]) {
                    if (!adUnit.mediaTypes.banner.sizes.some(existingSize => existingSize[0] === roleSize[0] && existingSize[1] === roleSize[1])) {
                        adUnit.mediaTypes.banner.sizes.push(roleSize);
                    }
                }
            }
        }
    }
    const signalElement = document.createElement("div");
    signalElement.id = "updateAdUnitsDone";
    document.body.appendChild(signalElement);

}



for (let i = 0; i < matches.length; i++) {
    if( matches[i].hasAttribute('role')){
        role = matches[i].getAttribute('role');
        matches[i].removeAttribute('role'); // do not use

        if(windowWidth < 728){
            if(role == "widescreen"){
                holidDebugLog("transforming widescreen into mobile");
                role = "mobile";
            } else if(role == "box"){
                holidDebugLog("transforming box into mobile");
                role = "mobile";
            }
        }
        matches[i].classList.add(role);
        console.log("Found old classic Role: "+role+", please migrate to classes or do not use at all.");
    }
}

function isVisible(ele) {
    if (!ele) return false;

    const style = getComputedStyle(ele);

    return style.display !== 'none';
}

function isElementInViewport (el) {
    var rect = el.getBoundingClientRect();

    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function addElement (id,targetObject,role) {
    var newDiv = document.createElement("div");
    newDiv.innerHTML = "";

    /* Native banner override, this will add code into the holid divs specified with the bannerOverride,  normal  execution flow stops. */
    for (var i = 0, len = bannerOverride.length; i < len; i++) {
        element = bannerOverride[i];
        if( element.code == id){
            newDiv.innerHTML = element.html;
            newDiv.setAttribute("id", "native-" + id);
        }
    }
    /* End of Native override */

    if(newDiv.innerHTML == ""){
        newDiv.setAttribute("id", id);
        newDiv.innerHTML =  ''; /*'<script>googletag.cmd.push(function() { googletag.display("'+id+'"); });</script>'; */
    }

    targetObject.appendChild(newDiv, targetObject);
}

function holid_find_empty_divs(){
    var matches = document.querySelectorAll('.holidAds,.holidads');

    var adUnit_counter = 0; //This is the Adunit iterration we are about to use next
    if (adUnits_holid.length < 1) { // adUnits_holid_counter
        console.log("HOLID: Out of AdUnits");
        refresh_continue = false;
        clearInterval(refresh_interval);
        clearInterval(interval);
        clearInterval(interval_check_time_in_view);
        clearInterval(holid_interval_find_empty_divs);
    } else {

        for (let i=0; i<matches.length; i++) {


            if(!isVisible (matches[i])){

            } else {
                var role = 0;

                var allClasses = matches[i].className;
                var allClasses_array = allClasses.split(" ");
                allClasses_array.forEach(function (item, index) {
                    acceptedFormat = acceptedFormats.includes(item);
                    if(acceptedFormat){
                        role = item;
                    }
                });
                var idToAdd = false;
                var found = false;
                /* Roles and Custom roles */
                if(role!=0 && matches[i].innerHTML==""){
                    if (windowWidth < 728 && role === "widescreen") {
                        role = "mobile" // Omvandlar widescreen till att anses som mobile
                    }
                    holidDebugLog("Trying to match a role of type: " + role);
                    adUnits_holid.forEach(function (item, key) {
                        if(typeof holid_div_ids[item.code] == "undefined"  && item.role==role && !found && !usedIds.includes(item.code)){
                            found = true;
                            usedIds.push(item.code);
                            holid_div_ids[item.code] = item.holidTag;
                            holidDebugLog("found in loop 1: " + item.code);
                            idToAdd = key;

                        }
                    });

                    if(!found){ /* if we did not find a fitting role, lets use a universal */
                        holidDebugLog("Did not find any more roles for type: " +role);
                        adUnits_holid.forEach(function (item, key) {
                            if(typeof item.role == "undefined" && !found && !usedIds.includes(item.code)){
                                found = true;
                                usedIds.push(item.code);
                                holid_div_ids[item.code] = item.holidTag;
                                holidDebugLog("Out of roles, selected a universal to fit the role: "+ role + " " + item.code);
                                idToAdd = key;
                                holidDebugLog(adUnits_holid[key].mediaTypes.banner);
                                adUnits_holid[key].mediaTypes.banner.sizes = ad_sizes[role];
                                holidDebugLog("Transforming universal role ("+item.code+") into a: "+ role);
                                adUnits_holid[key].role = role;
                                holidDebugLog(adUnits_holid[key].mediaTypes.banner);
                            }
                        });
                    }

                    // If there is no adunits with specified role left
                    if(adUnits_holid[idToAdd] === undefined || !found || (windowWidth>728 && role=="mobile") || (windowWidth<1024 && role=="tower")){
                        holidDebugLog("Disabled "  + role + " due to size rules not fullfilled.");
                        matches[i].innerHTML= " ";
                    } else {
                        holidDebugLog("Searched for role: " + role + ", found: "+ adUnits_holid[idToAdd].code + " with sizes:");
                        holidDebugLog(adUnits_holid[idToAdd].mediaTypes.banner.sizes);
                        addElement (adUnits_holid[idToAdd].code, matches[i], role); // Create Banner
                        holidDebugLog("Now Adding: " + adUnits_holid[idToAdd].code);
                    }
                } else if(matches[i].innerHTML==""){ /* Normal */
                    holidDebugLog("Trying to match Undefined / Universal Role ");
                    adUnits_holid.forEach(function (item, index) {
                        if(typeof holid_div_ids[item.code] == "undefined" && typeof item.role == "undefined" && !found && !usedIds.includes(item.code)){
                            found = true;
                            holid_div_ids[item.code] = item.holidTag;
                            addElement (item.code, matches[i], role); // Create Banner
                            usedIds.push(item.code); // Keep track on used ones...
                            holidDebugLog("Found and added " + item.code + " to be used.");
                        }
                    });
                    if(!found){
                        holidDebugLog("Disabled the undefined/universal div due to lack of universal adunits");
                        matches[i].innerHTML= " ";
                    }
                } else {

                }
            }
        }
    }
}

var holid_pbjs = holid_pbjs || {};
holid_pbjs.que = holid_pbjs.que || [];

var customConfigObject = {
    "buckets": [
        {
            "max": 60,
            "increment": 0.3
        },{
            "max": 200,
            "increment": 1
        }
    ]
};

function destroy_slots(callback){
    if(typeof adUnits_inUse !== 'undefined'){
        for (index = 0; index < adUnits_inUse.length; ++index) {
            let element = document.getElementById(adUnits_inUse[index].code);
            if(typeof(element) !== 'undefined' && element!== null  ){
                // div still exists
            } else {
                // div deleted, need to destroy slot and reuse
                if (typeof googletag.destroySlots === 'function') {
                    adUnits_holid.push(adUnits_inUse[index]);

                    googletag.destroySlots([slots[adUnits_inUse[index].code]]);
                    holid_pbjs.removeAdUnit(adUnits_inUse[index].code);

                    let code = adUnits_inUse[index].code;
                    delete holid_div_ids[code];

                    usedIds.splice(code,1);

                    adUnits_inUse.splice(index, 1);
                } else {
                    console.warn('googletag.destroySlots is not defined.');
                }
            }
        }
    }
    callback();
}

function getParentClassName(childNode){
    return childNode.parentNode.className;
}


function return_found_adUnits(id_only = false){
    var index;
    adUnits_found = [];
    var maxWidth;
    var maxHeight;
    var minWidth = 0;
    var role = false;
    if(typeof adUnits_holid !== 'undefined'){
        for (index = 0; index < adUnits_holid.length; ++index) {
            if(document.getElementById(adUnits_holid[index].code) && document.getElementById(adUnits_holid[index].code).innerHTML == "") { // only handle existing and Empty divs, some might be added in later stage

                var adDiv = document.getElementById(adUnits_holid[index].code)
                var allClasses = getParentClassName(adDiv);
                var allClasses_array = allClasses.split(" ");

                var tmpSize = [];
                var backupSize = [];

                allClasses_array.forEach(function (item, index) {
                    acceptedFormat = acceptedFormats.includes(item);
                    if(acceptedFormat){
                        role = item;
                    }
                });

                adUnits_inUse.push(adUnits_holid[index]); // Store all used adunits in its original form here

                var childDiv = document.getElementById(adUnits_holid[index].code);
                var parentDiv = childDiv.parentElement;
                var computedStyles = window.getComputedStyle(parentDiv);

                maxWidth = parseInt(computedStyles.getPropertyValue("max-width")) + 2; // add 2 pixels margin
                maxHeight = parseInt(computedStyles.getPropertyValue("max-height")) + 2;// add 2 pixels margin


    var computedStyle = window.getComputedStyle(document.getElementById(adUnits_holid[index].code).parentElement);
    var minWidth = computedStyle.getPropertyValue('min-width');
    
    if (minWidth !== 'none') {
        minWidth = parseInt(minWidth, 10);
        if (isNaN(minWidth)) {
            minWidth = 0;
        }
    } else {
        minWidth = 0;
    }


                // Om max-width eller max-height är 'none' eller tomma, använd width och height istället
                if (!maxWidth || maxWidth === 'none') {
                    maxWidth = parseInt(computedStyles.width);
                }

                if (!maxHeight || maxHeight === 'none') {
                    maxHeight = parseInt(computedStyles.height);
                }

                if(maxWidth < 103) // If no acceptable max-width is set, try to use normal width
                    maxWidth = parseInt(computedStyles.getPropertyValue("width")) + 2; // add 2 pixels margin

                if(maxHeight < 103) // If no acceptable max-height is set, try to use normal height 
                    maxHeight = parseInt(computedStyles.getPropertyValue("height")) + 2; // add 2 pixels margin

//                maxHeight = (maxWidth < 1024 && maxHeight > 501) && role!="tower" ? 482 : maxHeight ;// if it is mobile view, the max height for ads will be 482 (changed from 460)
                if(maxHeight < 10){
                    maxHeight = 320;
                    holidDebugLog("Settings max-height to default: " + maxHeight + " due to no sizes found.");
                }

                if (!maxWidth || maxWidth === 'none') {
                    maxWidth = 320;
                    holidDebugLog("Settings max-width to default: " + maxWidth + " due to no sizes found.");
                }

                /* Override om det är customs */
                if (customs.includes(role)) {
                    maxWidth = 2000;
                    minWidth = 0;
                }

                if(role=="tower")
                    maxHeight = 601;


                if (
                    Array.isArray(adUnits_holid[index].mediaTypes.banner.sizes_alwaysAllow) &&
                    typeof adUnits_holid[index].mediaTypes.banner.sizes_alwaysAllow.length !== 'undefined'
                ) {
                    tmpSize = adUnits_holid[index].mediaTypes.banner.sizes_alwaysAllow;
                    holidDebugLog("Adding always accepted sizes: " + adUnits_holid[index].mediaTypes.banner.sizes_alwaysAllow);
                }
                if (
                    Array.isArray(adUnits_holid[index].mediaTypes.banner.sizes) &&
                    typeof adUnits_holid[index].mediaTypes.banner.sizes.length !== 'undefined'
                ) {
                    for (var y = 0, lenSizes = adUnits_holid[index].mediaTypes.banner.sizes.length; y < lenSizes; y++) {
                        var element = adUnits_holid[index].mediaTypes.banner.sizes[y];

                        if(((element[0]>maxWidth) ||  (element[1] > maxHeight) || minWidth > element[0])  && role==false){
                            holidDebugLog(role + " :: " + adUnits_holid[index].code + " Removed: " + element[0] + "x" + element[1]+ " Due to size restrictions. This is what we found - maxWidth: " + maxWidth  + ", maxHeight: " + maxHeight + ", windowWidth: " + windowWidth + " minWidth: " + minWidth + " - Publisher need to make sure we can read available width/maxwidth and height/maxheight, we will not brute force ads into this div");

                            if(element[0]<maxWidth && element[1] < maxHeight) {
                                holidDebugLog("Added backup size: ");
                                holidDebugLog(element);
                                backupSize.push(adUnits_holid[index].mediaTypes.banner.sizes[y]);
                            }
                        } else {
                            if(role!=false){
                                       holidDebugLog("Added: " + element[0] + "x" + element[1]+ " - Due to that it is a 'role' and the size existed in the size array");
                            } else {
                                       holidDebugLog("Added: " + element[0] + "x" + element[1]+ " - All size rules fullfilled. maxWidth: " + maxWidth + ", windowWidth: " + windowWidth);
                            }
                            tmpSize.push(adUnits_holid[index].mediaTypes.banner.sizes[y]);
                        }
                    }
                    holidDebugLog('Length found for index:' + index);
                } else {
                    holidDebugLog('Length does not exist for index:' + index);
                }

                if(tmpSize.length<1)
                    tmpSize = backupSize; // If no good match is found, try to find anything smaller than max width

                if (typeof adUnits_holid[index].role === "undefined")
                    tmpSize.push([300, 300], [300, 250], [250, 250], [300, 50]);

                adUnits_holid[index].mediaTypes.banner.sizes = tmpSize;

                if(refresh_height){
                    var tmpSize_height = [];

                    for (var y = 0, lenSizes = adUnits_holid[index].mediaTypes.banner.sizes.length; y < lenSizes; y++) {
                        var element = adUnits_holid[index].mediaTypes.banner.sizes[y];
                        if(element[1]>maxHeight){
                            holidDebugLog("Removed: " + element[0] + "x" + element[1]+ " Due to size restrictions. maxHeight: " + maxHeight);
                        } else {
                            holidDebugLog("Added: " + element[0] + "x" + element[1]+ " Based on size rules. maxHeight: " + maxHeight);
                            tmpSize_height.push(adUnits_holid[index].mediaTypes.banner.sizes[y]);
                        }
                    }

                    tmpSize = tmpSize_height;

                    adUnits_holid[index].mediaTypes.banner.sizes = tmpSize;
                }
                holidDebugLog("Updated:" + adUnits_holid[index].code);
                holidDebugLog(adUnits_holid[index]);
                
                adUnits_found.push(adUnits_holid[index]);
                adUnits_holid.splice(index, 1);
                index--; // step back one step due to that we deleted one from the original array, otherwise we will jump one spot
            } else {
                // holidDebugLog("Did not find div id: " + adUnits_holid[index].code);
            }
        }
    }
    return adUnits_found;
}




//adUnits_found = return_found_adUnits();
function sendAdserverRequest() {
    if (holid_pbjs.adserverRequestSent) return;
    holid_pbjs.adserverRequestSent = true;
    googletag.cmd.push(function() {
        holid_pbjs.que.push(function() {

                        googletag.pubads().setTargeting('tier_One_Category', 'Uncategorized');

// Check if the holid_keyvalues array exists in the window object
            if (window.holid_keyvalues) {
                // Loop through the array
                for (const [key, value] of Object.entries(window.holid_keyvalues)) {
                    // Add the key
                    // console.log(`${key}: ${value}`);
                    googletag.pubads().setTargeting(key, value);
                }
            } else {
                holidDebugLog("The holid_keyvalues array does not exist in the window object.");
            }


            holid_pbjs.setTargetingForGPTAsync();
            googletag.pubads().refresh();
        });
    });
}





function holid_check_time_in_view(){
    var matches = document.querySelectorAll('.holidAds,.holidads')
    for (var i=0; i < matches.length; i++) {
        var div = matches[i].firstElementChild;
        if( div !== null) {
            var id = div.id;
            if (typeof div_ads[id] === 'undefined' ) {
                div_ads[id] = ["inview","outofview"];
                div_ads[id]["inview"] = 0;
                div_ads[id]["outofview"] = 0;


                /* ADDED DURING REFRESH DEVELOPMENT */
                div_ads[id]["refresh"] = "on";

                for (let x = 0; x < adUnits_inUse.length; x++) {
                    if (adUnits_inUse[x].refresh == "off") {
                        holidDebugLog("Refresh disabled for id: " + x + " with code: " + adUnits_inUse[x].code);

                        if(typeof div_ads[adUnits_inUse[x].code]  !== 'undefined')
                            div_ads[adUnits_inUse[x].code]["refresh"] = "off";
                    }
                }
                /* END ADDING REFRESH DEVELOPMENT */
            }

            if (isElementInViewport(matches[i])) {

                div_ads[id]["inview"] = 1;

                if (  id in divs_in_view ) {
                    divs_in_view[id]=divs_in_view[id]+holid_time_check;
                } else {
                    divs_in_view[id] = holid_time_check;
                    if(refresh_num>0){
                        divs_in_view[id] = ( -holid_time_extra_for_refreshed_banners );  // if this is a refresh then add 5 extra seconds to reduce to many refresh
                    }
                }

                if ( div_ads[id]["refresh"] == "on" &&
                        ( (div_ads[id]["inview"] == 1 && div_ads[id]["outofview"] == 1&& holid_time_minimum_before_refresh < holid_interval_counter) || 
                    holid_time_max_before_refreshed_banners_in_view < divs_in_view[id] && holid_time_minimum_before_refresh < holid_interval_counter)
                ) {

                    var clientHeight = div.parentNode.clientHeight;
                    if (clientHeight > 40) {
                        div.parentNode.style.minHeight = (clientHeight + "px");
                        div.parentNode.style.overflow = 'hidden';
                    }

                    divs_ready_for_refresh[id] = 0; // not really needed any longer?
                    divs_in_view[id] = (-holid_time_extra_for_refreshed_banners);
                    holid_refresh_current_ads(id);
                    div_ads[id]["inview"] = 0;
                    div_ads[id]["outofview"] = 0;
                    refresh_num++;
                }
            } else {
                var id = div.id;
                if(div_ads[id]["inview"] == 1) // if it has been in view, then proceed.
                    div_ads[id]["outofview"] = 1;
            }
        }
    }

    if(holid_refresh_max<=refresh_num){
        clearInterval(interval_check_time_in_view);
    }
}



function holid_show_ads(){
    let adUnits_found = return_found_adUnits();
    if(typeof adUnits_found !== 'undefined' && adUnits_found.length > 0) {
        // console.log(adUnits_found);
        holid_pbjs.que.push(function () {
            holid_pbjs.addAdUnits(adUnits_found);

            if(is_active_amazon_uam == true) {
               executeParallelAuctionAlongsidePrebid();
          } else {
             holid_pbjs.requestBids({
                 bidsBackHandler: sendAdserverRequest
             });
          }
        });

        if(is_active_amazon_uam == false) {
            setTimeout(function () {
                sendAdserverRequest();
            }, PREBID_TIMEOUT);
        }

        var interstitialSlot;

        googletag.cmd.push(function () {

            for (var y = 0, lenSizes = adUnits_found.length; y < lenSizes; y++) {
                var element = adUnits_found[y];

                if (document.getElementById(element.code)) {
                    if (typeof element.mediaTypes.banner == 'object') {
                        slot = googletag.defineSlot('/' + holidSiteId + '/' + element.holidTag, element.mediaTypes.banner.sizes, element.code).addService(googletag.pubads());
                    } else if (typeof element.mediaTypes.native == 'object') {
                        slot = googletag.defineSlot('/' + holidSiteId + '/' + element.holidTag, element.mediaTypes.native.image.sizes, element.code).addService(googletag.pubads());
                    }
                    slots[element.code] = slot;
                    /*
                    if(holid_interval_counter>10){ // 10 seconds wait before execute is possible ensure that none of the first ads will be refreshed instantly. Only ads added in later stage will be
                        holid_refresh_current_ads(element.code);
                    }
                    */
                }
            }

            
				googletag.pubads().enableLazyLoad({
					fetchMarginPercent: 320,  // Fetch slots within 3.2 viewports.
					renderMarginPercent: 300,  // Render slots within 3 viewports.
					mobileScaling: 1  // 1.1 times the above values on mobile.
				});

				for (var i = 0; i < adUnits_found.length; i++) {
					var element = adUnits_found[i];
					if (document.getElementById(element.code)) {
						if (element.hasOwnProperty("lazyLoad") && element.lazyLoad == "off") {
							googletag.display(element.code);
						} 
					}
				}
    		

            

            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            googletag.enableServices();
            holid_pbjs.adserverRequestSent = false;
        });
    }
}

function holid_refresh_current_ads(id){
    holid_pbjs.que.push(function() {
        holid_pbjs.requestBids({
            timeout: PREBID_TIMEOUT,
            adUnitCodes: ['/' + holidSiteId + '/' + holid_div_ids[id] ],
            bidsBackHandler: function() {
                holid_pbjs.setTargetingForGPTAsync(['/' + holidSiteId + '/'+holid_div_ids[id] ]);
                googletag.pubads().refresh([slots[id]]);
            }
        });
    });
}

function holid_init(){
    if(holid_cmp_status==="full_tcf_gpp"){
    //console.log("full_tcf_gpp");
        holid_pbjs.que.push(function () {
            holid_pbjs.aliasBidder('adform', 'keymobileadf', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'openrtb', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'adprofitadf', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('rubicon', 'adprofitrub', {
                gvlid: 52
            });
            holid_pbjs.aliasBidder('pubmatic', 'keymobilepubm', {
                gvlid: 76
            });
            holid_pbjs.aliasBidder('adform', 'traderaadform', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'traderaopenrtb', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('livewrapped', 'lwtwo', {
                gvlid: 919
            });
            holid_pbjs.aliasBidder('adform', 'adfmobagency', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('pubmatic', 'pubmmobagency', {
                gvlid: 76
            });
            holid_pbjs.aliasBidder('rubicon', 'rubmobagency', {
                gvlid: 52
            });            
            holid_pbjs.setConfig({
                realTimeData: {
                    dataProviders: [{
                        name: 'timeout',
                        params: {
                            rules: {
                                includesVideo: {
                                true: 1000,
                                false: 0
                                },
                                numAdUnits : {
                                "1-5": 0,
                                "6-10": 50,
                                "11-15": 100
                                },
                                deviceType: {
                                "2": 0,
                                "4": 50,
                                "5": 50
                                },
                                connectionSpeed: {
                                slow: 1000,
                                medium: 400,
                                fast: 0,
                                unknown: 400
                                }
                            }
                        }
                    }]
                },
                useBidCache: true,
                sizeConfig: [{
                    mediaQuery: '(min-width: 728px)',
                    labels: [ "desktop"]
                    }, {
                    mediaQuery: '(min-width: 0px) and (max-width: 727px)',
                    labels: [ "mobile"]
                }],
                paapi: {
                    enabled: true,
                    defaultForSlots: 1
                },
                enableTIDs: true,
                userSync: {
                    topics: { 
                        maxTopicCaller: 2,
                        bidders: [{
                            bidder: 'pubmatic',
                            iframeURL: 'https://ads.pubmatic.com/AdServer/js/topics/topics_frame.html'
                            },{
                            bidder: 'improvedigital',
                            iframeURL: 'https://hb.360yield.com/privacy-sandbox/topics.html'
                        }],
                    },
                    userIds: [{
                        name: 'sharedId',
                        storage: {
                            name: '_sharedID',
                            type: 'html5',
                            expires: 365
                        },
                        params: {
                            syncTime: 86400
                        }
                    },{
                        name: 'id5Id',
                        params: {
                            partner: 1361
                        },
                        storage: {
                            type: 'html5',
                            name: 'id5id',
                            expires: 90,
                            refreshInSeconds: 8*3600
                        }
                    }],
                    filterSettings: {
                        iframe: {
                            bidders: '*',
                            filter: 'include'
                        },
                        image: {
                            bidders: '*',
                            filter: 'include'
                        }
                    },
                    aliasSyncEnabled: true,
                    syncsPerBidder: 30
                },
                improvedigital: {usePrebidSizes: true},
                consentManagement: {
                    gpp: {
                        cmpApi: 'iab',
                        timeout: 8000
                    },
                    gdpr: {
                        cmpApi: 'iab',
                        timeout: 8000,
                        defaultGdprScope: true,
                        rules: [{
                            purpose: 'storage',
                            enforcePurpose: true,
                            enforceVendor: true,
                            vendorExceptions: ["id5id", "sharedId", "timeout"]
                        },{
                            purpose: 'basicAds',
                            enforcePurpose: false,
                            enforceVendor: false,
                            vendorExceptions: ["id5id", "sharedId", "timeout"]
                        },{
                            purpose: 'personalizedAds',
                            enforcePurpose: true,
                            enforceVendor: true,
                            vendorExceptions: ["id5id", "sharedId", "timeout"]
                        },{
                            purpose: 'measurement',
                            enforcePurpose: true,
                            enforceVendor: true,
                            vendorExceptions: ["id5id", "sharedId", "timeout"]
                        },{
                            purpose: 'transmitPreciseGeo',
                            enforcePurpose: true,
                            enforceVendor: true,
                            vendorExceptions: ["id5id", "sharedId", "timeout"]
                        }]
                    }
                },
                bidderSequence: 'random',
                priceGranularity: customConfigObject,
                currency: {
                    adServerCurrency: 'SEK',
                    conversionRateFile: 'https://cdn.jsdelivr.net/gh/prebid/currency-file@1/latest.json'
                },
                enableSendAllBids: true,
                bidderTimeout: PREBID_TIMEOUT
            });
            holid_pbjs.setBidderConfig({
    "bidders": ['adform', 'rubicon', 'improvedigital', 'appnexus', 'pubmatic', 'openrtb', 'criteo', 'ix'],
    "config": {
        "schain": {
            "validation": "strict",
            "config": {
                "ver": "1.0",
                "complete": 1,
                "nodes": [{
                    "asi": "holid.io",
                    "sid": "268",
                    "hp": 1
                }]
            }
        }
    }
});
holid_pbjs.setBidderConfig({
    "bidders": ['keymobileadf', 'keymobilepubm'],
    "config": {
        "schain": {
            "validation": "strict",
            "config": {
                "ver": "1.0",
                "complete": 1,
                "nodes": [{
                    "asi": "holid.io",
                    "sid": "268",
                    "hp": 1
                }, {
                    "asi": "keymobile.se",
                    "sid": "1014001",
                    "hp": 1
                }]
            }
        }
    }
});
        });
    }
    else if(holid_cmp_status==="full_gpp"){
    // console.log("full_gpp");
        holid_pbjs.que.push(function () {
            holid_pbjs.aliasBidder('adform', 'keymobileadf', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'openrtb', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'adprofitadf', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('rubicon', 'adprofitrub', {
                gvlid: 52
            });
            holid_pbjs.aliasBidder('pubmatic', 'keymobilepubm', {
                gvlid: 76
            });
            holid_pbjs.aliasBidder('adform', 'traderaadform', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'traderaopenrtb', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('livewrapped', 'lwtwo', {
                gvlid: 919
            });
            holid_pbjs.aliasBidder('adform', 'adfmobagency', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('pubmatic', 'pubmmobagency', {
                gvlid: 76
            });
            holid_pbjs.aliasBidder('rubicon', 'rubmobagency', {
                gvlid: 52
            });            
            holid_pbjs.setConfig({               
                realTimeData: {
                    dataProviders: [{
                        name: 'timeout',
                        params: {
                            rules: {
                                includesVideo: {
                                true: 1000,
                                false: 0
                                },
                                numAdUnits : {
                                "1-5": 0,
                                "6-10": 50,
                                "11-15": 100
                                },
                                deviceType: {
                                "2": 0,
                                "4": 50,
                                "5": 50
                                },
                                connectionSpeed: {
                                slow: 1000,
                                medium: 400,
                                fast: 0,
                                unknown: 400
                                }
                            }
                        }
                    }]
                },
                useBidCache: true,
                sizeConfig: [{
                    mediaQuery: '(min-width: 728px)',
                    labels: [ "desktop"]
                    }, {
                    mediaQuery: '(min-width: 0px) and (max-width: 727px)',
                    labels: [ "mobile"]
                }],
                paapi: {
                    enabled: true,
                    defaultForSlots: 1
                },
                enableTIDs: true,
                userSync: {
                    topics: { 
                        maxTopicCaller: 2,
                        bidders: [{
                            bidder: 'pubmatic',
                            iframeURL: 'https://ads.pubmatic.com/AdServer/js/topics/topics_frame.html'
                            },{
                            bidder: 'improvedigital',
                            iframeURL: 'https://hb.360yield.com/privacy-sandbox/topics.html'
                        }],
                    },                    
                    userIds: [{
                        name: 'sharedId',
                        storage: {
                            name: '_sharedID',
                            type: 'html5',
                            expires: 365
                        },
                        params: {
                            syncTime: 86400
                        }
                    },{
                        name: 'id5Id',
                        params: {
                            partner: 1361
                        },
                        storage: {
                            type: 'html5',
                            name: 'id5id',
                            expires: 90,
                            refreshInSeconds: 8*3600
                        }
                    }],
                    filterSettings: {
                        iframe: {
                            bidders: '*',
                            filter: 'include'
                        },
                        image: {
                            bidders: '*',
                            filter: 'include'
                        }
                    },
                    aliasSyncEnabled: true,
                    syncsPerBidder: 30
                },
                improvedigital: {usePrebidSizes: true},
                consentManagement: {
                    gpp: {
                        cmpApi: 'iab',
                        timeout: 8000
                    }
                },
                bidderSequence: 'random',
                priceGranularity: customConfigObject,
                currency: {
                    adServerCurrency: 'SEK',
                    conversionRateFile: 'https://cdn.jsdelivr.net/gh/prebid/currency-file@1/latest.json'
                },
                enableSendAllBids: true,
                bidderTimeout: PREBID_TIMEOUT
            });
            holid_pbjs.setBidderConfig({
    "bidders": ['adform', 'rubicon', 'improvedigital', 'appnexus', 'pubmatic', 'openrtb', 'criteo', 'ix'],
    "config": {
        "schain": {
            "validation": "strict",
            "config": {
                "ver": "1.0",
                "complete": 1,
                "nodes": [{
                    "asi": "holid.io",
                    "sid": "268",
                    "hp": 1
                }]
            }
        }
    }
});
holid_pbjs.setBidderConfig({
    "bidders": ['keymobileadf', 'keymobilepubm'],
    "config": {
        "schain": {
            "validation": "strict",
            "config": {
                "ver": "1.0",
                "complete": 1,
                "nodes": [{
                    "asi": "holid.io",
                    "sid": "268",
                    "hp": 1
                }, {
                    "asi": "keymobile.se",
                    "sid": "1014001",
                    "hp": 1
                }]
            }
        }
    }
});
        });
    }
    else if(holid_cmp_status === "not_needed"){
    //console.log("not_needed");
        holid_pbjs.que.push(function () {
            holid_pbjs.aliasBidder('adform', 'keymobileadf', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'openrtb', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'adprofitadf', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('rubicon', 'adprofitrub', {
                gvlid: 52
            });
            holid_pbjs.aliasBidder('pubmatic', 'keymobilepubm', {
                gvlid: 76
            });
            holid_pbjs.aliasBidder('adform', 'traderaadform', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'traderaopenrtb', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('livewrapped', 'lwtwo', {
                gvlid: 919
            });
            holid_pbjs.aliasBidder('adform', 'adfmobagency', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('pubmatic', 'pubmmobagency', {
                gvlid: 76
            });
            holid_pbjs.aliasBidder('rubicon', 'rubmobagency', {
                gvlid: 52
            });                
            holid_pbjs.setConfig({
                realTimeData: {
                    dataProviders: [{
                        name: 'timeout',
                        params: {
                            rules: {
                                includesVideo: {
                                true: 1000,
                                false: 0
                                },
                                numAdUnits : {
                                "1-5": 0,
                                "6-10": 50,
                                "11-15": 100
                                },
                                deviceType: {
                                "2": 0,
                                "4": 50,
                                "5": 50
                                },
                                connectionSpeed: {
                                slow: 1000,
                                medium: 400,
                                fast: 0,
                                unknown: 400
                                }
                            }
                        }
                    }]
                },
                useBidCache: true,
                sizeConfig: [{
                    mediaQuery: '(min-width: 728px)',
                    labels: [ "desktop"]
                    }, {
                    mediaQuery: '(min-width: 0px) and (max-width: 727px)',
                    labels: [ "mobile"]
                }],
                paapi: {
                    enabled: true,
                    defaultForSlots: 1
                },
                enableTIDs: true,
                userSync: {
                    topics: { 
                        maxTopicCaller: 2,
                        bidders: [{
                            bidder: 'pubmatic',
                            iframeURL: 'https://ads.pubmatic.com/AdServer/js/topics/topics_frame.html'
                            },{
                            bidder: 'improvedigital',
                            iframeURL: 'https://hb.360yield.com/privacy-sandbox/topics.html'
                        }],
                    },                    
                    userIds: [{
                        name: 'sharedId',
                        storage: {
                            name: '_sharedID',
                            type: 'html5',
                            expires: 365
                        },
                        params: {
                            syncTime: 86400
                        }
                    },{
                        name: 'id5Id',
                        params: {
                            partner: 1361
                        },
                        storage: {
                            type: 'html5',
                            name: 'id5id',
                            expires: 90,
                            refreshInSeconds: 8*3600
                        }
                    }],
                    filterSettings: {
                        iframe: {
                            bidders: '*',
                            filter: 'include'
                        },
                        image: {
                            bidders: '*',
                            filter: 'include'
                        }
                    },
                    aliasSyncEnabled: true,
                    syncsPerBidder: 30
                },
                improvedigital: {usePrebidSizes: true},
                bidderSequence: 'random',
                priceGranularity: customConfigObject,
                currency: {
                    adServerCurrency: 'SEK',
                    conversionRateFile: 'https://cdn.jsdelivr.net/gh/prebid/currency-file@1/latest.json'
                },
                enableSendAllBids: true,
                bidderTimeout: PREBID_TIMEOUT
            });
            holid_pbjs.setBidderConfig({
    "bidders": ['adform', 'rubicon', 'improvedigital', 'appnexus', 'pubmatic', 'openrtb', 'criteo', 'ix'],
    "config": {
        "schain": {
            "validation": "strict",
            "config": {
                "ver": "1.0",
                "complete": 1,
                "nodes": [{
                    "asi": "holid.io",
                    "sid": "268",
                    "hp": 1
                }]
            }
        }
    }
});
holid_pbjs.setBidderConfig({
    "bidders": ['keymobileadf', 'keymobilepubm'],
    "config": {
        "schain": {
            "validation": "strict",
            "config": {
                "ver": "1.0",
                "complete": 1,
                "nodes": [{
                    "asi": "holid.io",
                    "sid": "268",
                    "hp": 1
                }, {
                    "asi": "keymobile.se",
                    "sid": "1014001",
                    "hp": 1
                }]
            }
        }
    }
});
        });
    }
    else {
    //console.log("error");
        holid_pbjs.que.push(function () {
            holid_pbjs.aliasBidder('adform', 'keymobileadf', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'openrtb', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'adprofitadf', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('rubicon', 'adprofitrub', {
                gvlid: 52
            });
            holid_pbjs.aliasBidder('pubmatic', 'keymobilepubm', {
                gvlid: 76
            });
            holid_pbjs.aliasBidder('adform', 'traderaadform', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('adform', 'traderaopenrtb', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('livewrapped', 'lwtwo', {
                gvlid: 919
            });
            holid_pbjs.aliasBidder('adform', 'adfmobagency', {
                gvlid: 50
            });
            holid_pbjs.aliasBidder('pubmatic', 'pubmmobagency', {
                gvlid: 76
            });
            holid_pbjs.aliasBidder('rubicon', 'rubmobagency', {
                gvlid: 52
            });                
            holid_pbjs.setConfig({             
                realTimeData: {
                    dataProviders: [{
                        name: 'timeout',
                        params: {
                            rules: {
                                includesVideo: {
                                true: 1000,
                                false: 0
                                },
                                numAdUnits : {
                                "1-5": 0,
                                "6-10": 50,
                                "11-15": 100
                                },
                                deviceType: {
                                "2": 0,
                                "4": 50,
                                "5": 50
                                },
                                connectionSpeed: {
                                slow: 1000,
                                medium: 400,
                                fast: 0,
                                unknown: 400
                                }
                            }
                        }
                    }]
                },            
                useBidCache: true,
                sizeConfig: [{
                    mediaQuery: '(min-width: 728px)',
                    labels: [ "desktop"]
                    }, {
                    mediaQuery: '(min-width: 0px) and (max-width: 727px)',
                    labels: [ "mobile"]
                }],
                deviceAccess: false,
                enableTIDs: true,
                improvedigital: {usePrebidSizes: true},
                bidderSequence: 'random',
                priceGranularity: customConfigObject,
                currency: {
                    adServerCurrency: 'SEK',
                    conversionRateFile: 'https://cdn.jsdelivr.net/gh/prebid/currency-file@1/latest.json'
                },
                enableSendAllBids: true,
                bidderTimeout: PREBID_TIMEOUT
            });
            holid_pbjs.setBidderConfig({
    "bidders": ['adform', 'rubicon', 'improvedigital', 'appnexus', 'pubmatic', 'openrtb', 'criteo', 'ix'],
    "config": {
        "schain": {
            "validation": "strict",
            "config": {
                "ver": "1.0",
                "complete": 1,
                "nodes": [{
                    "asi": "holid.io",
                    "sid": "268",
                    "hp": 1
                }]
            }
        }
    }
});
holid_pbjs.setBidderConfig({
    "bidders": ['keymobileadf', 'keymobilepubm'],
    "config": {
        "schain": {
            "validation": "strict",
            "config": {
                "ver": "1.0",
                "complete": 1,
                "nodes": [{
                    "asi": "holid.io",
                    "sid": "268",
                    "hp": 1
                }, {
                    "asi": "keymobile.se",
                    "sid": "1014001",
                    "hp": 1
                }]
            }
        }
    }
});
        });
    }

    holid_pbjs.bidderSettings = {
        standard: {
            storageAllowed: true,
            bidCpmAdjustment: function (bidCpm) {
                return bidCpm * 1;
            }
        },
        keymobileadf: {
            storageAllowed: true,
            bidCpmAdjustment: function(bidCpm) {
                return bidCpm * 0.57;
            }
        },
        keymobilepubm: {
            storageAllowed: true,
            bidCpmAdjustment: function(bidCpm) {
                return bidCpm * 0.57;
            }
        },
        adprofitrub: {
            storageAllowed: true,
            bidCpmAdjustment: function(bidCpm) {
                return bidCpm * 0.64;
            }
        },
        leeadsadf: {
            storageAllowed: true,
            bidCpmAdjustment: function(bidCpm) {
                return bidCpm * 0.72;
            }
        },
        lwtwo: {
            storageAllowed: true,
            bidCpmAdjustment: function(bidCpm) {
                return bidCpm * 0.65;
            }
        },
        adfmobagency: {
            storageAllowed: true,
            bidCpmAdjustment: function(bidCpm) {
                return bidCpm * 0.60;
            }
        },
        pubmmobagency: {
            storageAllowed: true,
            bidCpmAdjustment: function(bidCpm) {
                return bidCpm * 0.60;
            }
        },
        rubmobagency: {
            storageAllowed: true,
            bidCpmAdjustment: function(bidCpm) {
                return bidCpm * 0.60;
            }
        }
    };

    holid_show_ads();

    (function() {
        // V3
        interval_check_time_in_view = setInterval(function() {
            holid_check_time_in_view();
        }, (holid_time_check*1000));

        holid_interval_find_empty_divs = setInterval(function() {
            destroy_slots(() => {
                holid_find_empty_divs();
                holid_show_ads();
            });
        }, PREBID_TIMEOUT + 100); // Do not run more often then the timeout limits

        holid_interval_timer = setInterval(function() {
            holid_interval_counter++;
        }, 1000); // Do not run more often then the timeout limits

    })();

    
}

function waitForElement(selector, callback) { /* Detta är för att försäkra mig om att den verkligen blir klar med adunits innan den går vidare */
    const interval = setInterval(() => {
        const element = document.querySelector(selector);
        if (element) {
            clearInterval(interval);
            callback(element);
        }
    }, 50);
}

function clearSignalElement(selector) {
    const element = document.querySelector(selector);
    if (element) {
        element.parentNode.removeChild(element);
        holidDebugLog("Deleted element");
    }
}

async function main() {
    await updateAdUnits(adUnits_holid, ad_sizes);
    await new Promise(resolve => waitForElement("#updateAdUnitsDone", resolve));
    await clearSignalElement("#updateAdUnitsDone");
    await holid_find_empty_divs();
    await waitForStatusChange();
}

main();


/* EOF */
