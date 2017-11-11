delimiter $$

create trigger UpdateVotesins after insert on PostVotes for each row begin if(new.weight = 1) then update Post set upvotes = upvotes + 1 where new.post_id = Post.post_id; elseif(new.weight = -1) then update Post set downvotes = downvotes +1 where new.post_id = Post.post_id; end if; end $$

create trigger UpdateVotesdel after delete on PostVotes for each row begin if(old.weight = 1) then update Post set upvotes = upvotes - 1 where old.post_id = Post.post_id; elseif(old.weight = -1) then update Post set downvotes = downvotes - 1 where old.post_id = Post.post_id; end if; end $$

delimiter ;
