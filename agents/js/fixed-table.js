function fixTable(container) {
  // Store references to table elements
  var thead = container.querySelector('thead');
  var tbody = container.querySelector('tbody');

  // Style container
  container.style.overflow = 'auto';
  container.style.position = 'relative';

  // Add inline styles to fix the header row and leftmost column
  function relayout() {
    var ths = [].slice.call(thead.querySelectorAll('th'));
    var tbodyTrs = [].slice.call(tbody.querySelectorAll('tr'));

    /**
     * Remove inline styles so we resort to the default table layout algorithm
     * For thead, th, and td elements, don't remove the 'transform' styles applied
     * by the scroll event listener
     */
    tbody.setAttribute('style', '');
    thead.style.position = '';
    thead.style.top = '';
    thead.style.left = '';
    thead.style.zIndex = '';
    ths.forEach(function(th) {
      th.style.display = '';
      th.style.position = '';
      th.style.top = '';
      th.style.left = '';
    });
    tbodyTrs.forEach(function(tr) {
      tr.setAttribute('style', '');
    });
    [].slice.call(tbody.querySelectorAll('td'))
      .forEach(function(td) {
        td.style.position = '';
        td.style.left = '';
      });

    /**
     * Store width and height of each th
     * getBoundingClientRect()'s dimensions include paddings and borders
     */
    var thStyles = ths.map(function(th) {
      var rect = th.getBoundingClientRect();
      var style = document.defaultView.getComputedStyle(th, '');
      return {
        boundingHeight: rect.height,
        paddingLeft: parseInt(style.paddingLeft, 10)
      };
    });

    // Set widths of thead and tbody
    
    tbody.style.display = '';

    // Position thead
    thead.style.position = '';
    thead.style.top = '0';
    thead.style.zIndex = 999;

   
  }

  // Initialize table styles
  relayout();

  // Update table cell dimensions on resize
  window.addEventListener('resize', resizeThrottler, false);
  var resizeTimeout;
  function resizeThrottler() {
    if (!resizeTimeout) {
      resizeTimeout = setTimeout(function() {
        resizeTimeout = null;
        relayout();
      }, 500);
    }
  }

  // Fix thead and first column on scroll
  container.addEventListener('scroll', function() {
    thead.style.transform = 'translate3d(0,' + this.scrollTop + 'px,0)';
    var hTransform = 'translate3d(' + this.scrollLeft + 'px,0,0)';
   
  });

  /**
   * Return an object that exposes the relayout function so that we can
   * update the table when the number of columns or the content inside columns changes
   */
  return {
    relayout: relayout
  };
}
