<?php 
	function instagram() { ?>

		<script>
			// https://github.com/SwetankPoddar/dynamic-instagram-gallery
			function fetch_posts(username) {
				$.getJSON(`https://www.instagram.com/1foryou/?__a=1`, (data) => {

					var template = $('#post_template').html();

					let media = data.graphql.user.edge_owner_to_timeline_media.edges;
					let gallery = $('#gallery');

					// If there is no media, display an error and leave
					if(media.length == 0){
						alert("No posts by this user");
						return;
					}

					// Loop through every post and create appropriate gallery for them
					var c = 0;
					media.forEach((post) => {

						c++;

						post = post.node;

						// Clone the template
						var item = $(template).clone();

						// Create image tag with the images
						var img = $('<img />', {
							class: "materialboxed",
							src: post.display_url
						});

						// Set the image
						$(item).find('.card-image').prepend(img);

						// Add a direct link to instagram post
						$(item).find('.open-instagram').attr("href", `https://www.instagram.com/p/${post.shortcode}/`);

						// Append the post to gallery
						gallery.append(item);

						if (c === 3) {
							media.length = media.indexOf(post);
						}
					});

				}).fail(function() {
					alert("Sorry, invalid username or a private account");
				});
			}

		</script>

		<script>

			$(function() {
				fetch_posts('<?php echo trim($insta); ?>');
			});
		</script>

		
	<?php }
?>