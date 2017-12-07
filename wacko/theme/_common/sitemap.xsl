<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
		version="1.0"
		xmlns:sm="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
		xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0"
		xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
		xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
		xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
		xmlns:fo="http://www.w3.org/1999/XSL/Format"
		xmlns:xhtml="http://www.w3.org/1999/xhtml"
		xmlns="http://www.w3.org/1999/xhtml">

	<xsl:output method="html" indent="yes" encoding="UTF-8"/>

	<xsl:template match="/">
		<html>
			<head>
				<title>
					Sitemap
					<xsl:if test="sm:sitemapindex">Index</xsl:if>
				</title>
				<style type="text/css">
					*{margin: 0;padding: 0;}
					body{color: #333;font-family: Arial;padding: 20px;font-size: 12px;}
					h1, h3{margin-bottom: 10px;}
					h1{font-size: 24px;}
					h3{font-size: 16px;}
					h1 span{font-size: 16px;color: #555;margin-left: 5px;}
					p{line-height: 20px;}
					table{font-size: 12px;}
					table th{background: #f5f5f5;}
					table td, table th{border: 1px #ccc solid;padding: 5px;text-align: left;}
					table{border-collapse: collapse;}
					table span{background: #ddd;padding: 0 3px;margin-left: 5px;}
				</style>
			</head>
			<body>
				<h1>
					Sitemap
					<xsl:if test="sm:sitemapindex">Index</xsl:if>
					<xsl:if test="sm:urlset/sm:url/mobile:mobile">
						<span>Mobile</span>
					</xsl:if>
					<xsl:if test="sm:urlset/sm:url/image:image">
						<span>Images</span>
					</xsl:if>
					<xsl:if test="sm:urlset/sm:url/news:news">
						<span>News</span>
					</xsl:if>
					<xsl:if test="sm:urlset/sm:url/video:video">
						<span>Video</span>
					</xsl:if>
					<xsl:if test="sm:urlset/sm:url/xhtml:link">
						<span>Xhtml</span>
					</xsl:if>
				</h1>
				<h3>
					<xsl:choose>
						<xsl:when test="sm:sitemapindex">
							This XML Sitemap Index file contains
							<xsl:value-of select="count(sm:sitemapindex/sm:sitemap)"/>
							sitemaps.
						</xsl:when>
						<xsl:otherwise>
							This XML Sitemap contains
							<xsl:value-of select="count(sm:urlset/sm:url)"/>
							URLs.
						</xsl:otherwise>
					</xsl:choose>
				</h3>

				<xsl:apply-templates/>

			</body>
		</html>
	</xsl:template>


	<xsl:template match="sm:sitemapindex">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<th></th>
				<th>URL</th>
				<th>Last Modified</th>
			</tr>
			<xsl:for-each select="sm:sitemap">
				<tr>
					<xsl:variable name="loc">
						<xsl:value-of select="sm:loc"/>
					</xsl:variable>
					<xsl:variable name="pno">
						<xsl:value-of select="position()"/>
					</xsl:variable>
					<td>
						<xsl:value-of select="$pno"/>
					</td>
					<td>
						<a href="{$loc}">
							<xsl:value-of select="sm:loc"/>
						</a>
					</td>
					<xsl:apply-templates/>
				</tr>
			</xsl:for-each>
		</table>
	</xsl:template>

	<xsl:template match="sm:urlset">
		<table cellSpacing="0" cellPadding="0" border="0">
			<tr>
				<th></th>
				<th>URL</th>
				<xsl:if test="sm:url/sm:lastmod">
					<th>Last Modified</th>
				</xsl:if>
				<xsl:if test="sm:url/sm:changefreq">
					<th>Change Frequency</th>
				</xsl:if>
				<xsl:if test="sm:url/sm:priority">
					<th>Priority</th>
				</xsl:if>
			</tr>
			<xsl:for-each select="sm:url">
				<tr>
					<xsl:variable name="loc">
						<xsl:value-of select="sm:loc"/>
					</xsl:variable>
					<xsl:variable name="pno">
						<xsl:value-of select="position()"/>
					</xsl:variable>
					<td>
						<xsl:value-of select="$pno"/>
					</td>
					<td>
						<p>
							<a href="{$loc}">
								<xsl:value-of select="sm:loc"/>
							</a>
						</p>
						<xsl:apply-templates select="xhtml:*"/>
						<xsl:apply-templates select="image:*"/>
						<xsl:apply-templates select="video:*"/>
					</td>
					<xsl:apply-templates select="sm:*"/>
				</tr>
			</xsl:for-each>
		</table>
	</xsl:template>

	<xsl:template match="sm:loc|image:loc|image:caption|video:*">
	</xsl:template>

	<xsl:template match="sm:lastmod|sm:changefreq|sm:priority">
		<td>
			<xsl:apply-templates/>
		</td>
	</xsl:template>

	<xsl:template match="xhtml:link">
		<xsl:variable name="altloc">
			<xsl:value-of select="@href"/>
		</xsl:variable>
		<p>
			Xhtml:
			<a href="{$altloc}">
				<xsl:value-of select="@href"/>
			</a>
			<span>
				<xsl:value-of select="@hreflang"/>
			</span>
			<span>
				<xsl:value-of select="@rel"/>
			</span>
			<span>
				<xsl:value-of select="@media"/>
			</span>
		</p>
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="image:image">
		<xsl:variable name="loc">
			<xsl:value-of select="image:loc"/>
		</xsl:variable>
		<p>
			Image:
			<a href="{$loc}">
				<xsl:value-of select="image:loc"/>
			</a>
			<span>
				<xsl:value-of select="image:caption"/>
			</span>
			<xsl:apply-templates/>
		</p>
	</xsl:template>
	<xsl:template match="video:video">
		<xsl:variable name="loc">
			<xsl:choose>
				<xsl:when test="video:player_loc != ''">
					<xsl:value-of select="video:player_loc"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="video:content_loc"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		<p>
			Video:
			<a href="{$loc}">
				<xsl:choose>
					<xsl:when test="video:player_loc != ''">
						<xsl:value-of select="video:player_loc"/>
					</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="video:content_loc"/>
					</xsl:otherwise>
				</xsl:choose>
			</a>
			<span>
				<xsl:value-of select="video:title"/>
			</span>
			<span>
				<xsl:value-of select="video:thumbnail_loc"/>
			</span>
			<xsl:apply-templates/>
		</p>
	</xsl:template>
</xsl:stylesheet>