# Security Policy

We take the security of WackoWiki seriously. This document describes what we do and do not consider a security vulnerability and how to get one fixed.

## Reporting a vulnerability

If you believe you have found a vulnerability, get in touch through any of these channels:

* Send an e-mail to [Maintainer](mailto:webmaster@wackowiki.org) (plaintext — prefer the advisory channel for sensitive reports)
* Open a [GitHub Security Advisory](https://github.com/WackoWiki/wackowiki/security/advisories) — preferred for anything that is not yet public
* Open a [GitHub Issue](https://github.com/WackoWiki/wackowiki/issues) — note that issues are public immediately, so please use the advisory channel for undisclosed vulnerabilities

A useful report describes how to reproduce the problem and explains the impact. Suggestions for a fix are welcome, but not required.

## Supported versions

We only accept reports for the current stable release (branch `master`) and the previous minor release branch. Older versions are not supported, and any vulnerabilities in them will not be fixed. Please upgrade to a current release before reporting.

## Reaction & mitigation times

All work is done by volunteers in their spare time. We aim to acknowledge your report within 48 hours.
If you haven't received a response within 7 days, please follow up.
We will keep you updated about the availability of a fix. Fixes are usually available within a few days, but may take longer if the issue is complex or if we are waiting for a response from you.

We assign a severity rating in the advisory using the CVSS v3.1 scale.

Depending on the severity, we will either release a hotfix for the current stable release or fold the fix into the next regular release.

## Non-qualifying vulnerabilities

Not every undesirable behavior is a security vulnerability, and treating one as such tends to create noise rather than make anyone safer. The following are out of scope for this policy:

* **Performance problems and Denial of Service.**
  Runaway regexes, `max_execution_time` timeouts, memory exhaustion and DoS in general are bugs, not vulnerabilities — report them as regular [bugs](https://github.com/WackoWiki/wackowiki/issues), ideally with a fix that does not break legitimate use.
* **Behaviour of external software.**
  How other software interprets WackoWiki's output is not our concern, as long as our output is standards-compliant.
* **Server-Side Request Forgery (SSRF).**
  Access to intranet resources is a feature for many deployments. Isolating the wiki server from sensitive hosts is the responsibility of the network administrator.
* **Misconfiguration of the installation.**
  Problems that only arise from an insecure setup — for example serving internal data or configuration files to the web server, or running under PHP settings that are unsafe for a wiki — are configuration issues, not vulnerabilities.
* **Anything that requires administrator access.**
  Administrators are fully trusted and can already run arbitrary code, so config-based XSS or installing a malicious extension is not a vulnerability.
* **Attacks that require physical or network access.**
  Man-in-the-middle and similar attacks that presuppose control over the device or network are out of scope.
* **Third-party plugins and templates.**
  Only WackoWiki and its bundled plugins and themes are covered here. Issues in other extensions are to be reported to their respective contacts.

## Public disclosure, credits and bounties

Privately reported vulnerabilities are published as a GitHub Security Advisory once a fix is available. We credit the reporter in the advisory unless they request anonymity. A link to the advisory is included in the release notes.

We do not request CVE identifiers. Each advisory carries a GHSA identifier (e.g., `GHSA-abc1-2345-6789`), which serves as the canonical reference for the vulnerability.

We do not offer bounties for vulnerabilities.   
