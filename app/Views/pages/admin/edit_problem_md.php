<!-- {#
 # SharIF Judge
 # file: edit_problem_md.php
 # author: Filipus Setio Nugroho <filipussetio@gmail.com>
 #} -->
<?= $this->extend('templates/base') ?>
<?= $this->section('icon') ?>fa-edit<?= $this->endSection()?>
<?= $this->section('title') ?>Edit Problem Description (Markdown)<?= $this->endSection() ?>
<?= $this->section('head_title') ?>Edit Problem Description (Markdown)<?= $this->endSection() ?>



<?= $this->section('other_assets') ?>
<script type='text/javascript' src="<?= base_url('assets/js/taboverride.min.js') ?>"></script>
<script>
$(document).ready(function(){
		tabOverride.set(document.getElementById('md_editor'));
		$switch = false;
		$("textarea").keyup(function (e) {
			if (e.which==27){
				tabOverride.set(document.getElementById('md_editor'),$switch);
				$switch = !$switch;
    		}
		});
	});
</script>
<?= $this->endSection() ?>



<?= $this->section('main_content') ?>
<div class="pull-right md_cheatsheet">
<h2>Markdown Cheatsheet</h2>
From <a href="http://daringfireball.net/projects/markdown/dingus">Daring Fireball</a>
<h3>Headers</h3>

<p>Setext-style:</p>

<pre><code>Header 1
========

Header 2
--------
</code></pre>

<p>atx-style (closing #'s are optional):</p>

<pre><code># Header 1 #

## Header 2 ##

###### Header 6
</code></pre>

<h3>Phrase Emphasis</h3>

<pre><code>*italic*   **bold**
_italic_   __bold__
</code></pre>

<h3>Code Spans</h3>

<pre><code>`&lt;code&gt;` spans are delimited
by backticks.</code></pre>

<h3>Fenced Code Blocks</h3>
<pre>
```
function test() {
	printf("Hello World!\n");
}
```</pre>
<h3>Syntax Highlighting</h3>
<code>c</code>, <code>cpp</code>, <code>python</code> and <code>java</code> supported.
<pre>
```python
def test:
	print ("Python Syntax")
```</pre>

<h3>Preformatted Code Blocks</h3>

<p>Indent every line of a code block by at least 4 spaces or 1 tab.</p>

<pre><code>This is a normal paragraph.

    This is a preformatted
    code block.
</code></pre>

<h3>Lists</h3>

<p>Ordered, without paragraphs:</p>

<pre><code>1.  Foo
2.  Bar
</code></pre>

<p>Unordered, with paragraphs:</p>

<pre><code>*   A list item.

    With multiple paragraphs.

*   Bar
</code></pre>

<p>You can nest them:</p>

<pre><code>*   Item 1
    * item
*   Item 2
    1.  item 1
    2.  item 2
        * item
    3. item 3
*   Item 3
</code></pre>

<h3>Links</h3>

<p>Inline:</p>

<pre><code>An [example](http://url.com/ "Title")
</code></pre>

<p>Reference-style labels (titles are optional):</p>

<pre><code>An [example][id]. Then, anywhere
else in the doc, define the link:

  [id]: http://example.com/  "Title"
</code></pre>
<h3>Images</h3>

<p>Inline (titles are optional):</p>

<pre><code>![alt text](/path/img.jpg "Title")
</code></pre>

<p>Reference-style:</p>

<pre><code>![alt text][id]

[id]: /url/to/img.jpg "Title"
</code></pre>
<h3>Blockquotes</h3>

<pre><code>&gt; Email-style angle brackets
&gt; are used for blockquotes.

&gt; &gt; And, they can be nested.

&gt; #### Headers in blockquotes
&gt;
&gt; * You can quote a list.
&gt; * Etc.
</code></pre>
<h3>Horizontal Rules</h3>

<p>Three or more dashes or asterisks:</p>

<pre><code>---

* * *

- - - -
</code></pre>

<h3>Manual Line Breaks</h3>

<p>End a line with two or more spaces:</p>

<pre><code>Roses are red,
Violets are blue.
</code></pre>
</div>

<div id="md_div">
	<p>
		Assignment <?= $description_assignment['id'] ?> (<span dir="auto"><?= $description_assignment['name'] ?></span>)<br>
		Problem <?= $problem['id'] ?>
	</p>
	<?= form_open("problems/edit/md/".$description_assignment['id'].'/'.$problem['id']) ?>
	<span class="form_comment clear">Press "esc" to enable/disable tabindent</span><br>
	<p class="input_p">
		<textarea dir="auto" name="text" rows="30" cols="75" class="sharif_input" id="md_editor" aria-label="Markdown Editor"><?= $problem['description'] ?></textarea>
	</p>
	<p class="input_p">
		<input type="submit" value="Save" class="sharif_input"/>
	</p>
	</form>
</div>

<?= $this->endSection() ?>